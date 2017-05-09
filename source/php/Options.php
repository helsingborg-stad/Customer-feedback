<?php

namespace CustomerFeedback;

class Options
{
    public function __construct()
    {
        // Add settings page if ACF is installed
        add_action('plugins_loaded', array($this, 'register'));
        add_filter('acf/load_field/name=customer_feedback_posttypes', array($this, 'posttypes'));
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

    public function posttypes($field)
    {
        $field['choices']['page'] = __('Pages');

        foreach ($this->getPublicPostTpyes() as $key => $posttype) {
            $field['choices'][$key] = $posttype->label;
        }

        return $field;
    }

    public function getPublicPostTpyes($filter = array())
    {
        $postTypes = array();

        foreach (get_post_types() as $key => $postType) {
            $args = get_post_type_object($postType);

            if (!$args->public || $args->name === 'page') {
                continue;
            }

            $postTypes[$postType] = $args;
        }

        if (!empty($filter)) {
            $postTypes = array_filter($postTypes, function ($item) use ($filter) {
                if (substr($item, 0, 4) === 'mod-') {
                    return false;
                }

                return !in_array($item, $filter);
            });
        }

        return $postTypes;
    }
}
