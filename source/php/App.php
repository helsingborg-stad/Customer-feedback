<?php

namespace CustomerFeedback;

class App
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('admin_enqueue_scripts', array($this, 'adminEnqueue'));

        add_filter('acf/settings/load_json', array($this, 'jsonLoadPath'));

        new Responses();
        new Form();
        new Options();
    }

    public function jsonLoadPath($paths)
    {
        $paths[] = CUSTOMERFEEDBACK_PATH . 'source/acf-export';
        return $paths;
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/js/CustomerFeedback.min.js', array('jquery'), '1.0.0', true);
    }

    public function adminEnqueue()
    {
        wp_enqueue_style('customer-feedback', CUSTOMERFEEDBACK_URL . '/dist/css/CustomerFeedback.min.css', false, '1.0.0');
    }
}
