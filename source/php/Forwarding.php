<?php

namespace CustomerFeedback;

class Forwarding
{
    public static function maybeForward($answerId, $postId, $comment, $email)
    {
        self::globalForwarding($answerId, $postId, $comment, $email);
        self::localForwarding($answerId, $postId, $comment, $email);
    }

    public static function globalForwarding()
    {
        $to = get_field('feedback_forwarding', 'option');

        if (empty($to)) {
            return;
        }

        $subject = get_field('email_subject', 'option');
        $message = get_field('email_lead_message', 'option');
        $message .= '<br><br>' . $comment;
        $message .= '<br><br>' . __('Sent from:', 'customer-feedback') . ' ' . get_permalink($postId);

        $from = get_post_meta($answerId, 'customer_feedback_email', true);
        if (empty($from)) {
            $from = get_option('admin_email');
            $message = '<strong>' . __('Note: The sender did not leave his/her email address. You will not be able to answer this feedback message.', 'customer-feedback') . '</strong><br><br>' . $message;
        }

        foreach ($to as $email) {
            wp_mail(
                $email,
                $subject,
                $message,
                array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: ' . $from
                )
            );
        }
    }
}
