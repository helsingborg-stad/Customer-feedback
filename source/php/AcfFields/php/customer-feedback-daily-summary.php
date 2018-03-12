<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_591c150dd4561',
    'title' => 'Summaries',
    'fields' => array(
        0 => array(
            'key' => 'field_591c15305ade0',
            'label' => __('Send summaries to', 'customer-feedback'),
            'name' => 'customer_feedback_summary',
            'type' => 'repeater',
            'instructions' => __('Send summaries of feedback to the following email addresses', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'sub_fields' => array(
                0 => array(
                    'key' => 'field_591c155a5ade1',
                    'label' => __('Email address', 'customer-feedback'),
                    'name' => 'email_address',
                    'type' => 'email',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                ),
                1 => array(
                    'key' => 'field_591c50317fdbb',
                    'label' => __('Interval', 'customer-feedback'),
                    'name' => 'interval',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'multiple' => 0,
                    'allow_null' => 0,
                    'choices' => array(
                        'monthly' => __('Monthly', 'customer-feedback'),
                        'weekly' => __('Weekly', 'customer-feedback'),
                        'daily' => __('Daily', 'customer-feedback'),
                    ),
                    'default_value' => array(
                        0 => 'weekly',
                    ),
                    'ui' => 0,
                    'ajax' => 0,
                    'placeholder' => '',
                    'return_format' => 'value',
                ),
            ),
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'collapsed' => '',
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