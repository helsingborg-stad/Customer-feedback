<?php

/**
 * Plugin Name:       Customer Feedback Chat
 * Plugin URI:        https://github.com/helsingborg-stad/Customer-feedback-chat
 * Description:       Customer feedback chat is a heler plugin that will help you setup customer feedback chat via Vergic services.
 * Version:           1.0.0
 * Author:            Kristoffer Svanmark
 * Author URI:        https://github.com/helsingborg-stad
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       customer-feedback-chat
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('CUSTOMERFEEDBACKCHAT_PATH', plugin_dir_path(__FILE__));
define('CUSTOMERFEEDBACKCHAT_URL', plugins_url('', __FILE__));
define('CUSTOMERFEEDBACKCHAT_TEMPLATE_PATH', CUSTOMERFEEDBACKCHAT_PATH . 'templates/');

load_plugin_textdomain('CustomerFeedbackChat', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once CUSTOMERFEEDBACKCHAT_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once CUSTOMERFEEDBACKCHAT_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new CustomerFeedbackChat\Vendor\Psr4ClassLoader();
$loader->addPrefix('CustomerFeedbackChat', CUSTOMERFEEDBACKCHAT_PATH);
$loader->addPrefix('CustomerFeedbackChat', CUSTOMERFEEDBACKCHAT_PATH . 'source/php/');
$loader->register();

// Start application
new CustomerFeedbackChat\App();
