<?php

namespace CustomerFeedback;

class App
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));

        new Responses();
        new Form();
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script('customer-feedback-chat', CUSTOMERFEEDBACK_URL . '/dist/js/CustomerFeedback.min.js', false, '1.0.0', true);
    }
}
