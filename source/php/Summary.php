<?php

declare(strict_types=1);

namespace CustomerFeedback;

class Summary
{
    public static $resultCache = array();

    public function __construct()
    {
        add_action('admin_menu', array($this, 'addPage'));

        // Cron stuff
        add_action('customer-feedback/email_summary', array($this, 'emailSummary'), 10, 2);

        // Schedule on save
        add_action('acf/save_post', array($this, 'schedule'), 20);
    }

    /**
     * Schedule the stuff
     * @param  int $postId
     * @return void
     */
    public function schedule($postId)
    {
        if ($postId !== 'options' || !isset($_GET['page']) || $_GET['page'] !== 'acf-options-feedback-options') {
            return;
        }

        wp_unschedule_hook('customer-feedback/email_summary');
        wp_clear_scheduled_hook('customer-feedback/email_summary');

        $this->scheduleNextSummary($this->getSummaryRecipients());
    }

    /**
     * Group summary recipients by interval and remove invalid entries.
     *
     * @return array<string, array<int, string>>
     */
    private function getSummaryRecipients(): array
    {
        $summaries = get_field('customer_feedback_summary', 'option');

        if (empty($summaries)) {
            return array();
        }

        $recipients = array();

        foreach ($summaries as $summary) {
            if (empty($summary['email_address']) || empty($summary['interval'])) {
                continue;
            }

            $recipients[$summary['interval']][] = $summary['email_address'];
        }

        return $recipients;
    }

    /**
     * Schedule the next due summary event. There is only one pending cron job,
     * even when several summary intervals or recipients are configured.
     *
     * @param array<string, array<int, string>> $recipients
     * @return void
     */
    private function scheduleNextSummary(array $recipients): void
    {
        if (empty($recipients)) {
            return;
        }

        $intervalsByTimestamp = array();

        foreach (array_keys($recipients) as $interval) {
            $timestamp = $this->getScheduleTimestamp($interval);
            $intervalsByTimestamp[$timestamp][] = $interval;
        }

        ksort($intervalsByTimestamp, SORT_NUMERIC);
        $timestamp = array_key_first($intervalsByTimestamp);

        wp_schedule_single_event(
            $timestamp,
            'customer-feedback/email_summary',
            array($intervalsByTimestamp[$timestamp]),
        );
    }

    /**
     * Get the next run time for a summary schedule.
     *
     * All summaries run at 10:00 in the site's configured timezone. Weekly
     * summaries are anchored to Monday and monthly summaries to the first day
     * of the month, rather than to the time the options page was last saved.
     *
     * @param string $interval
     * @return int
     */
    private function getScheduleTimestamp(string $interval): int
    {
        $now = new \DateTimeImmutable('now', wp_timezone());

        if ($interval === 'weekly') {
            $scheduled = $now->modify('monday this week')->setTime(10, 0);

            if ($scheduled <= $now) {
                $scheduled = $scheduled->modify('next monday');
            }

            return $scheduled->getTimestamp();
        }

        if ($interval === 'monthly') {
            $scheduled = $now->modify('first day of this month')->setTime(10, 0);

            if ($scheduled <= $now) {
                $scheduled = $scheduled->modify('first day of next month');
            }

            return $scheduled->getTimestamp();
        }

        $scheduled = $now->setTime(10, 0);

        if ($scheduled <= $now) {
            $scheduled = $scheduled->modify('+1 day');
        }

        return $scheduled->getTimestamp();
    }

    /**
     * Send all summaries that are due and queue the next single cron event.
     *
     * @param array<int, string> $intervals
     * @return void
     */
    public function emailSummary($intervals = array()): void
    {
        $recipients = $this->getSummaryRecipients();

        // Replace an event created by versions that scheduled one job per
        // recipient. The next run will use the consolidated event instead.
        if (!is_array($intervals)) {
            wp_clear_scheduled_hook('customer-feedback/email_summary');
            $this->scheduleNextSummary($recipients);
            return;
        }

        foreach ($intervals as $interval) {
            if (empty($recipients[$interval])) {
                continue;
            }

            $this->sendSummary($recipients[$interval], $interval);
        }

        $this->scheduleNextSummary($recipients);
    }

    /**
     * Send one summary to all recipients for an interval.
     *
     * @param array<int, string> $recipients
     * @param string $interval
     * @return void
     */
    private function sendSummary(array $recipients, string $interval): void
    {
        $report = null;
        $from = null;
        $to = null;

        //Get iterval
        switch ($interval) {
            case 'monthly':
                $from = date('Y-m-d', strtotime('-30 days'));
                $to = date('Y-m-d');
                break;

            case 'weekly':
                $from = date('Y-m-d', strtotime('-7 days'));
                $to = date('Y-m-d');
                break;

            case 'daily':
                $from = date('Y-m-d');
                $to = date('Y-m-d');
                break;
        }

        // Get report (fetch from cache if any)
        if ($this->getCachedResult($interval) !== false) {
            $report = $this->getCachedResult($interval);
            $hasContent = !empty($report) ? true : false;
        } else {
            [$rendered, $hasContent] = $this->renderReport($from, $to, true);
            $report = self::$resultCache[$interval] = $rendered;
        }

        //Send non empty reports
        if (!empty($report) && !empty($hasContent)) {
            $report = '<html><body style="background:#fff;padding: 50px; font-family: Arial, Verdana, sans-serif;">' . $report . '</body></html>';
            wp_mail(
                get_option('admin_email'),
                __('Feedback summary', 'customer-feedback') . ' (' . get_option('blogname') . ')',
                $report,
                array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: ' . get_option('admin_email'),
                    'Bcc: ' . implode(', ', array_unique($recipients)),
                ),
            );
        }
    }

    /**
     * Get's cache response if any
     */
    public function getCachedResult($interval)
    {
        if (!empty(self::$resultCache[$interval])) {
            return self::$resultCache[$interval];
        }
        return false;
    }

    /**
     * Adds summary page to menu
     */
    public function addPage()
    {
        add_submenu_page(
            'edit.php?post_type=customer-feedback',
            __('Summary', 'customer-feedback'),
            __('Summary', 'customer-feedback'),
            'edit_posts',
            'customer-feedback-summary',
            array($this, 'renderReport'),
        );
    }

    /**
     * Renders summary report
     * @return void
     */
    public function renderReport($from = null, $to = null, $return = false)
    {
        // Get dates from querystring
        if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
            $from = $_GET['date_from'];
        }

        if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
            $to = $_GET['date_to'];
        }

        if (isset($_GET['date']) && !empty($_GET['date'])) {
            $to = $_GET['date'];
            $from = $_GET['date'];
        }

        // Fallback to last week
        if (empty($from) && empty($to)) {
            $from = date('Y-m-d', strtotime('-1 week'));
            $to = date('Y-m-d');
        }

        // Get data from dates
        [$data, $hasContent] = $this->getDataBetween($from, $to);

        // Get question
        $mainQuestion = __('Did the information on this page help you?', 'customer-feedback');
        if (!empty(get_field('customer_feedback_main_question_text', 'option'))) {
            $mainQuestion = get_field('customer_feedback_main_question_text', 'option');
        }

        $mainQuestionSub = __('Answer the question to help us improve our information.', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_main_question_sub', 'option'))) {
            $mainQuestionSub = get_field('customer_feedback_main_question_sub', 'option');
        }

        // Render view
        if ($return) {
            ob_start();
            include CUSTOMERFEEDBACK_TEMPLATE_PATH . '/summary-view.php';
            return [ob_get_clean(), $hasContent];
        } else {
            include CUSTOMERFEEDBACK_TEMPLATE_PATH . '/summary-view.php';
        }
    }

    /**
     * Gets relevant data for the summary
     * @param  string $from Date from
     * @param  string $to   Date to
     * @return array        Data
     */
    public function getDataBetween($from = null, $to = null)
    {
        $answerPosts = $this->getAnswerPosts($from, $to);

        $yesno = array('yes' => 0, 'no' => 0);
        $pending = array();

        foreach ($answerPosts as $post) {
            $topics = wp_get_post_terms($post->ID, 'feedback_topic');
            $feedback_topics = array();
            if (!empty($topics)) {
                foreach ($topics as $topic) {
                    $feedback_topics[] = $topic->name;
                }
            }

            $post->answer = array(
                'post_id' => get_post_meta($post->ID, 'customer_feedback_page_reference', true),
                'answer' => get_post_meta($post->ID, 'customer_feedback_answer', true),
                'comment' => get_post_meta($post->ID, 'customer_feedback_comment', true),
                'topics' => $feedback_topics,
            );

            // Count yes/no
            switch ($post->answer['answer']) {
                case 'yes':
                    $yesno['yes']++;
                    break;

                case 'no':
                    $yesno['no']++;
                    break;
            }

            if ($post->post_status === 'pending') {
                $pending[] = $post;
            }
        }

        // Get the percentage ratio for $yesno
        $totalAnswers = array_sum($yesno);
        $yesnoPercent = array_map(static function ($item) use ($totalAnswers) {
            if ($totalAnswers === 0) {
                return 0;
            }

            return ($item / $totalAnswers) * 100;
        }, $yesno);

        // Return array
        $data = array(
            'count' => $yesno,
            'percent' => $yesnoPercent,
            'pending' => $pending,
        );

        return [$data, !empty($yesno['yes']) || !empty($yesno['no'])];
    }

    /**
     * Get answer posts between dates
     * @param  string $from Date from
     * @param  string $to   Date to
     * @return array        Answer posts
     */
    public function getAnswerPosts($from = null, $to = null)
    {
        $answerPosts = array(
            'posts_per_page' => -1,
            'post_type' => 'customer-feedback',
            'post_status' => array('publish', 'pending', 'draft'),
        );

        $answerPosts['date_query'] = array(
            'inclusive' => true,
        );

        if (!is_null($from)) {
            $answerPosts['date_query']['after'] = $from;
        }

        if (!is_null($to)) {
            $answerPosts['date_query']['before'] = $to;
        }

        $answerPosts = new \WP_Query($answerPosts);
        return $answerPosts->posts;
    }
}
