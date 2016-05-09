<?php

namespace CustomerFeedback;

class Form
{
    public function __construct()
    {
        add_action('the_content', array($this, 'appendForm'));
    }

    /**
     * Appends the "did you find what you are looking for"
     * form to the bottom of the content if inside the main loop and content has characters
     * @param  string $content The original content
     * @return string          The original content with form appended to bottom
     */
    public function appendForm($content)
    {
        if (!in_the_loop() || strlen($content) === 0) {
            return $content;
        }

        ob_start();

        $mainQuestion = __('Did the information on this page help you?', 'customer-feedback');
        if (!empty(get_field('customer_feedback_main_question_text', 'option'))) {
            $mainQuestion = get_field('customer_feedback_main_question_text', 'option');
        }

        $mainQuestionSub = __('Answer the question to help us improve our information.', 'customer-feedback');
        if (!empty(get_field('customer_feedback_main_question_sub', 'option'))) {
            $mainQuestionSub = get_field('customer_feedback_main_question_sub', 'option');
        }

        $commentLabel = __('How can we make the information better?', 'customer-feedback');
        if (!empty(get_field('customer_feedback_feedback_label', 'option'))) {
            $commentLabel = get_field('customer_feedback_feedback_label', 'option');
        }

        $thanksText = __('Thank you', 'customer-feedback');
        if (!empty(get_field('customer_feedback_thanks', 'option'))) {
            $thanksText = get_field('customer_feedback_thanks', 'option');
        }

        include CUSTOMERFEEDBACK_TEMPLATE_PATH . 'form.php';

        $form = ob_get_clean();
        $content .= $form;
        return $content;
    }
}
