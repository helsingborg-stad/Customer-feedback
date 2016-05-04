<?php

namespace CustomerFeedbackChat;

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
        include CUSTOMERFEEDBACKCHAT_TEMPLATE_PATH . 'form.php';
        $form = ob_get_clean();

        $content .= $form;
        return $content;
    }
}
