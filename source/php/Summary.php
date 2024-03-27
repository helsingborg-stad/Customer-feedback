<?php

namespace CustomerFeedback;

class Summary
{

    public static $resultCache = array();

    public function __construct()
    {
        add_action('admin_menu', array($this, 'addPage'));

        // Cron stuff
        add_filter('cron_schedules', array($this, 'cronSchedules'));
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

        $summaries = get_field('customer_feedback_summary', 'option');

        if (empty($summaries)) {
            return;
        }

        foreach ($summaries as $summary) {
            wp_schedule_event(
                strtotime('tomorrow midnight -3 hour'),
                $summary['interval'],
                'customer-feedback/email_summary',
                array(
                    $summary['email_address'],
                    $summary['interval']
                )
            );
        }
    }

    /**
     * Add weekly and monthly schedules to cron
     * @param  array $schedules
     * @return array
     */
    public function cronSchedules($schedules)
    {
        $schedules['weekly'] = array(
            'interval' => 604800,
            'display' => __('weekly', 'customer-feedback')
        );

        $schedules['monthly'] = array(
            'interval' => 2592000,
            'display' => __('monthly', 'customer-feedback')
        );

        return $schedules;
    }

    public function emailSummary($email, $interval)
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
                $email,
                __('Feedback summary', 'customer-feedback') . ' (' . get_option('blogname') . ')',
                $report,
                array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: ' . get_option('admin_email')
                )
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
            array($this, 'renderReport')
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
                'topics' => $feedback_topics
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
        $yesnoPercent = array_map(function ($item) use ($totalAnswers) {
            if ($totalAnswers === 0) {
                return 0;
            }

            return ($item / $totalAnswers) * 100;
        }, $yesno);

        // Return array
        $data = array(
            'count' => $yesno,
            'percent' => $yesnoPercent,
            'pending' => $pending
        );

        return [$data, (!empty($yesno['yes']) || !empty($yesno['no']))];
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
            'inclusive' => true
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
