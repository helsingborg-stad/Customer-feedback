<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_59118fb9c53de',
    'title' => __('Feedback options', 'customer-feedback'),
    'fields' => array(
        0 => array(
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'key' => 'field_59118fbef0608',
            'label' => __('Main question', 'customer-feedback'),
            'name' => 'customer_feedback_main_question_text',
            'type' => 'text',
            'instructions' => __('Leave empty to use default.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
        ),
        1 => array(
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'key' => 'field_5911901df0609',
            'label' => __('Sub question', 'customer-feedback'),
            'name' => 'customer_feedback_main_question_sub',
            'type' => 'text',
            'instructions' => __('Leave empty to use default.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
        ),
        2 => array(
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'key' => 'field_5911905af060a',
            'label' => __('Feedback form label', 'customer-feedback'),
            'name' => 'customer_feedback_feedback_label',
            'type' => 'text',
            'instructions' => __('Leave empty to use default.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
        ),
        3 => array(
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'key' => 'field_59119076f060b',
            'label' => __('Completion message', 'customer-feedback'),
            'name' => 'customer_feedback_thanks',
            'type' => 'text',
            'instructions' => __('Leave empty to use default.', 'customer-feedback'),
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