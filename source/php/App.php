<?php

namespace CustomerFeedback;
use \HelsingborgStad\RecaptchaIntegration as Captcha;

/**
 * Class App
 * @package CustomerFeedback
 */
class App
{
    /**
     * App constructor.
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('admin_enqueue_scripts', array($this, 'adminEnqueue'));
        add_action('add_meta_boxes', array($this, 'removeUnwantedModuleMetaboxes'));
        add_action('loop_end', function() {
            if(!defined('CUSTOMER_FEEDBACK_DISABLE_AUTO_LOAD')) {
                do_action('customer-feedback'); 
            }
        });

        new Responses();
        new Summary();
        new Form();
        new Options();
    }

    /**
     * @param $postType
     */
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
        wp_enqueue_script('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/' . Helper\CacheBust::name('js/customer-feedback.js', false, '1.0.0', true));
        wp_localize_script('customer-feedback', 'feedback', array(
            'comment_min_characters' => sprintf(__('The comment must be more than %s characters.', 'customer-feedback'), '15'),
            'select_topic' => __('Please select a topic.', 'customer-feedback'),
            'enter_email' => __('Please enter a valid email.', 'customer-feedback')
        ));

        wp_enqueue_style('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/' . Helper\CacheBust::name('css/customer-feedback.css', false, '1.0.0'));

        global $post;
        $allowedPostTypes = apply_filters('CustomerFeedback/post_types', get_field('customer_feedback_posttypes', 'option'));
        $allowedPostTypes = (empty($allowedPostTypes)) ? array('page') : $allowedPostTypes;

        if (is_object($post) && in_array($post->post_type, $allowedPostTypes) && (is_single() || is_page())) {
            // If Captcha Script is not Enqueued
            if( !wp_script_is( 'municipio-google-recaptcha' ) ) {
                Captcha::initScripts();
            }
        }

    }

    public function adminEnqueue()
    {
        wp_enqueue_style('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/' . Helper\CacheBust::name('css/admin-customer-feedback.css', false, '1.0.0'));
    }
}
