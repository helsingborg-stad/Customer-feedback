<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_591c10ab88d77',
    'title' => __('Feedback forwarding', 'customer-feedback'),
    'fields' => array(
        0 => array(
            'sub_fields' => array(
                0 => array(
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'key' => 'field_591c117d32f13',
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
            'key' => 'field_591c116932f12',
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
                'param' => 'post_type',
                'operator' => '!=',
                'value' => 'mod-notice',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));
}