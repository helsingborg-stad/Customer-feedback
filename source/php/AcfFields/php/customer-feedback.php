<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5729fc6e03367',
    'title' => __('Feedback data', 'customer-feedback'),
    'fields' => array(
        0 => array(
            'layout' => 'horizontal',
            'choices' => array(
                'yes' => __('Yes', 'customer-feedback'),
                'no' => __('No', 'customer-feedback'),
            ),
            'default_value' => '',
            'other_choice' => 0,
            'save_other_choice' => 0,
            'allow_null' => 0,
            'return_format' => 'value',
            'key' => 'field_5729fc752e558',
            'label' => __('Answer', 'customer-feedback'),
            'name' => 'customer_feedback_answer',
            'type' => 'radio',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
        ),
        1 => array(
            'default_value' => '',
            'new_lines' => 'wpautop',
            'maxlength' => '',
            'placeholder' => '',
            'rows' => '',
            'key' => 'field_5729fcc62e559',
            'label' => __('Comment', 'customer-feedback'),
            'name' => 'customer_feedback_comment',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_5729fc752e558',
                        'operator' => '==',
                        'value' => 'no',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'readonly' => 1,
            'disabled' => 0,
        ),
        2 => array(
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'key' => 'field_57e8c6907c267',
            'label' => __('Email', 'customer-feedback'),
            'name' => 'customer_feedback_email',
            'type' => 'email',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'readonly' => 1,
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'customer-feedback',
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