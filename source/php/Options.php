<?php

namespace CustomerFeedback;

class Options
{
    public function __construct()
    {
            add_action('admin_menu', function () {
                if (function_exists('acf_add_options_sub_page')) {
                    acf_add_options_sub_page(array(
                        'title'      => 'Settings',
                        'parent'     => 'edit.php?post_type=customer-feedback',
                        'capability' => 'manage_options'
                    ));
                }
            });
    }
}
