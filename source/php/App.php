<?php

declare(strict_types=1);

namespace CustomerFeedback;

use WpUtilService\Features\Enqueue\EnqueueManager;

/**
 * Class App
 * @package CustomerFeedback
 */
class App
{
    /**
     * App constructor.
     */
    public function __construct(
        private EnqueueManager $wpEnqueue,
    ) {
        add_action('admin_enqueue_scripts', array($this, 'adminEnqueue'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'), 30);
        add_action('add_meta_boxes', array($this, 'removeUnwantedModuleMetaboxes'));

        new Responses();
        new Summary();
        (new Form())->addHooks();
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
        $this->wpEnqueue
            ->add('js/customer-feedback.js', [], '1.0.0', true)
            ->with()
            ->translation('feedback', array(
                'comment_min_characters' => sprintf(__('The comment must be more than %s characters.', 'customer-feedback'), '15'),
                'select_topic' => __('Please select a topic.', 'customer-feedback'),
                'enter_email' => __('Please enter a valid email.', 'customer-feedback'),
            ))
            ->add('css/customer-feedback.css');
    }

    public function adminEnqueue()
    {
        $this->wpEnqueue->add('css/admin-customer-feedback.css', [], '1.0.0');
    }
}
