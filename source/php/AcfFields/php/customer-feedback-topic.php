<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_59c9fb38d7e15',
    'title' => __('Feedback topic', 'customer-feedback'),
    'fields' => array(
        0 => array(
            'key' => 'field_59c9fb9093d94',
            'label' => __('Users can give written feedback', 'customer-feedback'),
            'name' => 'topic_feedback_capability',
            'aria-label' => '',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => __('If this is enabled, a textfield will appear when the topic is selected.', 'customer-feedback'),
            'default_value' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
            'ui' => 1,
        ),
        1 => array(
            'key' => 'field_67e1748ad8e8d',
            'label' => __('Users can give email in written feedback', 'customer-feedback'),
            'name' => 'topic_feedback_capability_email',
            'aria-label' => '',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_59c9fb9093d94',
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
            'message' => __('If this is enabled, a email field will appear when the topic is selected.', 'customer-feedback'),
            'default_value' => 1,
            'ui_on_text' => '',
            'ui_off_text' => '',
            'ui' => 1,
        ),
        2 => array(
            'key' => 'field_59d60e93873e6',
            'label' => __('Forwarding', 'customer-feedback'),
            'name' => 'topic_feedback_forwarding',
            'aria-label' => '',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => __('Forward feedback from this topic', 'customer-feedback'),
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'taxonomy',
                'operator' => '==',
                'value' => 'feedback_topic',
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