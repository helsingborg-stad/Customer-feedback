<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_59118fb9c53de',
    'title' => __('Feedback options', 'customer-feedback'),
    'fields' => array(
        0 => array(
            'key' => 'field_59118fbef0608',
            'label' => __('Main question', 'customer-feedback'),
            'name' => 'customer_feedback_main_question_text',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => __('Leave empty to use default.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
        ),
        1 => array(
            'key' => 'field_5911901df0609',
            'label' => __('Sub question', 'customer-feedback'),
            'name' => 'customer_feedback_main_question_sub',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => __('Leave empty to use default.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
        ),
        2 => array(
            'key' => 'field_5911905af060a',
            'label' => __('Feedback form label for negative feedback', 'customer-feedback'),
            'name' => 'customer_feedback_feedback_label_no',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => __('Feedback form label if answer is "No". Leave empty to use default.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        3 => array(
            'key' => 'field_595f8d9d2bf2c',
            'label' => __('Feedback form label for positive feedback', 'customer-feedback'),
            'name' => 'customer_feedback_feedback_label_yes',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => __('Feedback form label if answer is "Yes". Leave empty to use default.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        4 => array(
            'key' => 'field_59ca1b4fd1228',
            'label' => __('Feedback form label for topic', 'customer-feedback'),
            'name' => 'customer_feedback_label_topic',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => __('Leave empty to use default', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        5 => array(
            'key' => 'field_59119076f060b',
            'label' => __('Completion message', 'customer-feedback'),
            'name' => 'customer_feedback_thanks',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => __('Leave empty to use default.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
        ),
        6 => array(
            'key' => 'field_67e26273806c0',
            'label' => __('Feedback frequency', 'customer-feedback'),
            'name' => 'customer_feedback_feedback_frequency',
            'aria-label' => '',
            'type' => 'number',
            'instructions' => __('Set how often a user can give feedback', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 7,
            'min' => 0,
            'max' => 365,
            'placeholder' => '',
            'step' => '',
            'prepend' => '',
            'append' => '',
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
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
    'acfe_display_title' => '',
    'acfe_autosync' => '',
    'acfe_form' => 0,
    'acfe_meta' => '',
    'acfe_note' => '',
));
}