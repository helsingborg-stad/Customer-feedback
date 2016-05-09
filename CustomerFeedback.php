<?php

/**
 * Plugin Name:       Customer Feedback
 * Plugin URI:        https://github.com/helsingborg-stad/Customer-feedback
 * Description:       Puts a customer feedback form on each page
 * Version:           1.0.0
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
define('CUSTOMERFEEDBACK_TEMPLATE_PATH', CUSTOMERFEEDBACKCHAT_PATH . 'templates/');

load_plugin_textdomain('CustomerFeedback', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once CUSTOMERFEEDBACK_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once CUSTOMERFEEDBACK_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new CustomerFeedbackChat\Vendor\Psr4ClassLoader();
$loader->addPrefix('CustomerFeedback', CUSTOMERFEEDBACK_PATH);
$loader->addPrefix('CustomerFeedback', CUSTOMERFEEDBACK_PATH . 'source/php/');
$loader->register();

// Start application
new CustomerFeedback\App();
