<?php

namespace CustomerFeedback;

class Form
{
    public function __construct()
    {
        add_action('customer-feedback', array($this, 'appendForm'));
    }

    /**
     * Appends the "did you find what you are looking for"
     * form to the bottom of the content if inside the main loop and content has characters
     * @param  string $content The original content
     * @return string          The original content with form appended to bottom
     */
    public function appendForm()
    {
        global $post;

        $allowedPostTypes = apply_filters('CustomerFeedback/post_types', get_field('customer_feedback_posttypes', 'option'));
        if (is_null($allowedPostTypes)) {
            $allowedPostTypes = array('page');
        }

        if (!is_array($allowedPostTypes) || !in_array($post->post_type, $allowedPostTypes)) {
            return;
        }

        $postExtended = get_extended($post->post_content);

        if (empty($postExtended['main']) || (strpos($post->post_content, '<!--more-->') !== false && empty($postExtended['extended']))) {
            return;
        }

        $mainQuestion = __('Did the information on this page help you?', 'customer-feedback');
        if (!empty(get_field('customer_feedback_main_question_text', 'option'))) {
            $mainQuestion = get_field('customer_feedback_main_question_text', 'option');
        }

        $mainQuestionSub = __('Answer the question to help us improve our information.', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_main_question_sub', 'option'))) {
            $mainQuestionSub = get_field('customer_feedback_main_question_sub', 'option');
        }

        $negativeLabel = __('How can we make the information better?', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_feedback_label_no', 'option'))) {
            $negativeLabel = get_field('customer_feedback_feedback_label_no', 'option');
        }

        $positiveLabel = __('Comment', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_feedback_label_yes', 'option'))) {
            $positiveLabel = get_field('customer_feedback_feedback_label_yes', 'option');
        }

        $emailLabel = __('Email address', 'customer-feedback');
        $emailExplain = __('Please give us your email address to get a reply on your feedback.', 'customer-feedback');

        $thanksText = __('Thank you', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_thanks', 'option'))) {
            $thanksText = get_field('customer_feedback_thanks', 'option');
        }

        $userEmail = null;
        if (is_user_logged_in()) {
            $userdata = get_userdata(get_current_user_id());
            $userEmail = $userdata->user_email;
        }

        $topics = get_terms( array(
            'taxonomy' => 'feedback_topic',
            'hide_empty' => false,
        ));

        $topicLabel = __('Topic', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_label_topic', 'option'))) {
            $topicLabel = get_field('customer_feedback_label_topic', 'option');
        }

        if (!empty($topics)) {
            foreach ($topics as $topic) {
                $topic->feedback_capability = get_field('topic_feedback_capability', 'feedback_topic_' . $topic->term_id);
            }
        }

        $reCaptcha = (!is_user_logged_in() && defined('G_RECAPTCHA_KEY')) ? G_RECAPTCHA_KEY : '';

        include CUSTOMERFEEDBACK_TEMPLATE_PATH . 'form.php';
    }
}
