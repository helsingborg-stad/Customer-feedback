<?php

/**
 * Plugin Name:       Customer Feedback
 * Plugin URI:        https://github.com/helsingborg-stad/Customer-feedback
 * Description:       Puts a customer feedback form on each page
 * Version: 4.1.12
 * Author:            Kristoffer Svanmark
 * Author URI:        https://github.com/helsingborg-stad
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       customer-feedback
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('CUSTOMERFEEDBACK_PATH', plugin_dir_path(__FILE__));
define('CUSTOMERFEEDBACK_URL', plugins_url('', __FILE__));
define('CUSTOMERFEEDBACK_TEMPLATE_PATH', CUSTOMERFEEDBACK_PATH . 'templates/');

if (file_exists(CUSTOMERFEEDBACK_PATH . 'vendor/autoload.php')) {
    require_once CUSTOMERFEEDBACK_PATH . 'vendor/autoload.php';
}

add_action('init', function () {
    load_plugin_textdomain('customer-feedback', false, plugin_basename(dirname(__FILE__)) . '/languages');
});

// Acf auto import and export
add_action('plugins_loaded', function () {
    $acfExportManager = new \AcfExportManager\AcfExportManager();
    $acfExportManager->setTextdomain('customer-feedback');
    $acfExportManager->setExportFolder(CUSTOMERFEEDBACK_PATH . 'source/php/AcfFields/');
    $acfExportManager->autoExport(array(
        'customer-feedback'                   => 'group_5729fc6e03367',
        'customer-feedback-settings'          => 'group_59118fb9c53de',
        'customer-feedback-posttypes'         => 'group_591191a388456',
        'customer-feedback-forwarding-page'   => 'group_591c10ab88d77',
        'customer-feedback-forwarding-global' => 'group_591c026b10920',
        'customer-feedback-daily-summary'     => 'group_591c150dd4561',
        'customer-feedback-topic'             => 'group_59c9fb38d7e15'
    ));
    $acfExportManager->import();
});

// Start application
new CustomerFeedback\App();
