<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5b45f5d0c19c7',
    'title' => 'Feedback GDPR',
    'fields' => array(
        0 => array(
            'key' => 'field_5b45f5eade81d',
            'label' => __('GDPR Complience notice', 'customer-feedback'),
            'name' => 'gdpr_complience_notice',
            'type' => 'true_false',
            'instructions' => __('Contains information about how personal data is handled.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
        1 => array(
            'key' => 'field_5b45f9f1aa067',
            'label' => __('GDPR complience notice content', 'customer-feedback'),
            'name' => 'gdpr_complience_notice_content',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_5b45f5eade81d',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => __('When you submit the form, we will process your personal information to perform the task that the form concerns. The data will not be used for any other purpose.', 'customer-feedback'),
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
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