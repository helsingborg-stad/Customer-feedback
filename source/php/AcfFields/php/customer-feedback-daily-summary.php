<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_591c150dd4561',
    'title' => __('Daily summary', 'customer-feedback'),
    'fields' => array(
        0 => array(
            'sub_fields' => array(
                0 => array(
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'key' => 'field_591c155a5ade1',
                    'label' => __(__(__(__(__('Email address', 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'),
                    'name' => 'email_address',
                    'type' => 'email',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                ),
            ),
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'collapsed' => '',
            'key' => 'field_591c15305ade0',
            'label' => __('Daily summary', 'customer-feedback'),
            'name' => 'customer_feedback_daily_summary',
            'type' => 'repeater',
            'instructions' => __('Send daily summary of feedback to the following email addresses', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'acf-options-feedback-options',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));
}