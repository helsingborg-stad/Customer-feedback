<?php

namespace CustomerFeedback;
use \HelsingborgStad\RecaptchaIntegration as Captcha;

class App
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'), 30);
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
        if (!is_array($allowedPostTypes)) {
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
            'comment_min_characters' => sprintf(__('The comment must be more than %s characters.', 'customer-feedback'), '15'),
            'select_topic' => __('Please select a topic.', 'customer-feedback')
        ));

        global $post;
        $allowedPostTypes = apply_filters('CustomerFeedback/post_types', get_field('customer_feedback_posttypes', 'option'));
        $allowedPostTypes = (empty($allowedPostTypes)) ? array('page') : $allowedPostTypes;

        if (is_object($post) && in_array($post->post_type, $allowedPostTypes) && (is_single() || is_page())) {
            if (!wp_script_is('municipio-google-recaptcha')) {
                Captcha::initScripts();
            }
        }
    }

    public function adminEnqueue()
    {
        wp_enqueue_style('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/css/CustomerFeedback.min.css', false, '1.0.0');
    }
}
