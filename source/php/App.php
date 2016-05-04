<?php

namespace CustomerFeedbackChat;

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
        wp_enqueue_script('customer-feedback-chat', CUSTOMERFEEDBACKCHAT_URL . '/dist/js/CustomerFeedbackChat.min.js', false, '1.0.0', true);
    }
}
