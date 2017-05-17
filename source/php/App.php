<?php

namespace CustomerFeedback;

class App
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('admin_enqueue_scripts', array($this, 'adminEnqueue'));

        new Responses();
        new DailySummary();
        new Form();
        new Options();
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/js/CustomerFeedback.min.js', false, '1.0.0', true);
    }

    public function adminEnqueue()
    {
        wp_enqueue_style('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/css/CustomerFeedback.min.css', false, '1.0.0');
    }
}
