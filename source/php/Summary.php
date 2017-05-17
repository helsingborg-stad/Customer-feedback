<?php

namespace CustomerFeedback;

class Summary
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addPage'));
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
    public function renderReport()
    {
        $from = null;
        $to = null;

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
        if (is_null($from) && is_null($to)) {
            $from = date('Y-m-d', strtotime('-1 week'));
            $to = date('Y-m-d');
        }

        // Get data from dates
        $data = $this->getDataBetween($from, $to);

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
        include_once CUSTOMERFEEDBACK_TEMPLATE_PATH . '/summary-view.php';
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
            $post->answer = array(
                'post_id' => get_post_meta($post->ID, 'customer_feedback_page_reference', true),
                'answer' => get_post_meta($post->ID, 'customer_feedback_answer', true),
                'comment' => get_post_meta($post->ID, 'customer_feedback_comment', true)
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

        return $data;
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
