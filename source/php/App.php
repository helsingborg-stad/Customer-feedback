<?php

namespace CustomerFeedback;

class App
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('admin_enqueue_scripts', array($this, 'adminEnqueue'));
        add_action('add_meta_boxes', array($this, 'removeUnwantedModuleMetaboxes'));

        new Responses();
        new Summary();
        new Form();
        new Options();
    }

    public function removeUnwantedModuleMetaboxes($postType)
    {
        $allowedPostTypes = apply_filters('CustomerFeedback/post_types', get_field('customer_feedback_posttypes', 'option'));
        if (is_null($allowedPostTypes)) {
            $allowedPostTypes = array('page');
        }

        if (!in_array($postType, $allowedPostTypes)) {
            remove_meta_box('acf-group_591c10ab88d77', $postType, 'side');
        }
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/js/CustomerFeedback.min.js', false, '1.0.0', true);
        wp_localize_script('customer-feedback', 'feedback', array(
            'site_key' => (defined('G_RECAPTCHA_KEY')) ? G_RECAPTCHA_KEY : '',
            'comment_min_characters' => sprintf(__('The comment must be more than %s characters.', 'customer-feedback'), '15'),
            'select_topic' => __('Please select a topic.', 'customer-feedback')
        ));

        global $post;
        $allowedPostTypes = apply_filters('CustomerFeedback/post_types', get_field('customer_feedback_posttypes', 'option'));
        $allowedPostTypes = (!is_null($allowedPostTypes)) ? array('page') : $allowedPostTypes;
        if (is_object($post) && in_array($post->post_type, $allowedPostTypes) && (is_single() || is_page())) {
            wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit', '', '1.0.0', true);
        }
    }

    public function adminEnqueue()
    {
        wp_enqueue_style('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/css/CustomerFeedback.min.css', false, '1.0.0');
    }
}
