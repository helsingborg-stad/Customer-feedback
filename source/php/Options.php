<?php

namespace CustomerFeedback;

class Options
{
    public function __construct()
    {
        // Add settings page if ACF is installed
        add_action('plugins_loaded', array($this, 'register'));
    }

    public function register()
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(array(
                'title'      => __('Feedback options', 'customer-feedback'),
                'parent'     => 'edit.php?post_type=customer-feedback',
                'capability' => 'manage_options'
            ));
        }

        // Add needs attention page
        add_action('admin_menu', function () {
            add_submenu_page('edit.php?post_type=customer-feedback', 'Needs attention', 'Needs attention', 'edit_posts', 'customer-feedback-attention', function () {

                echo '<div class="wrap">';
                echo '<h1>' . __('Needs attention', 'customer-feedback') . '</h1>';
                echo '<p>' . __('This view shows pages that has a negative feedback rate of 30% or more. You should consider improving these pages.', 'customer-feedback') . '</p>';

                $table = new NeedsAttention();
                $table->prepare_items();
                $table->display();

                echo '</div>';
            });
        });
    }
}
