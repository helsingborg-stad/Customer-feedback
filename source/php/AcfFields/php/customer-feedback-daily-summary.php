<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_591c150dd4561',
    'title' => __('Summaries', 'customer-feedback'),
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
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                ),
                1 => array(
                    'multiple' => 0,
                    'allow_null' => 0,
                    'choices' => array(
                        'monthly' => __(__(__(__(__('Monthly', 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'),
                        'weekly' => __(__(__(__(__('Weekly', 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'),
                        'daily' => __(__(__(__(__('Daily', 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'),
                    ),
                    'default_value' => array(
                        0 => 'weekly',
                    ),
                    'ui' => 0,
                    'ajax' => 0,
                    'placeholder' => '',
                    'return_format' => 'value',
                    'key' => 'field_591c50317fdbb',
                    'label' => __(__(__(__(__('Interval', 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'),
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
                ),
            ),
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'collapsed' => '',
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