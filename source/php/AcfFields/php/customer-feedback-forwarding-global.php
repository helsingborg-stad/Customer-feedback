<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_591c026b10920',
    'title' => __('Feedback forwarding (globally)', 'customer-feedback'),
    'fields' => array(
        0 => array(
            'message' => __('You can use feedback forwarding to forward feedback to specified email addresses. Only feedback with comments will be forwarded.

Feedback forwarding can be set for individual pages (do this by editing the specific page) or for all pages (right below).', 'customer-feedback'),
            'esc_html' => 0,
            'new_lines' => 'wpautop',
            'key' => 'field_591c027ec29f4',
            'label' => __('What is feedback forwarding?', 'customer-feedback'),
            'name' => '',
            'type' => 'message',
            'instructions' => '',
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
            'key' => 'field_591c0c4f09e80',
            'label' => __('Email subject', 'customer-feedback'),
            'name' => 'email_subject',
            'type' => 'text',
            'instructions' => '',
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
            'new_lines' => 'wpautop',
            'maxlength' => '',
            'placeholder' => '',
            'rows' => '',
            'key' => 'field_591c0c5d09e81',
            'label' => __('Email lead message', 'customer-feedback'),
            'name' => 'email_lead_message',
            'type' => 'textarea',
            'instructions' => __('The feedback comment will be appended automatically.', 'customer-feedback'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
        ),
        3 => array(
            'sub_fields' => array(
                0 => array(
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'key' => 'field_591c0494c29f6',
                    'label' => __(__(__(__(__('E-postadress', 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'), 'customer-feedback'),
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
            'key' => 'field_591c02e3c29f5',
            'label' => __('Feedback forwarding', 'customer-feedback'),
            'name' => 'feedback_forwarding',
            'type' => 'repeater',
            'instructions' => '',
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