<?php

namespace CustomerFeedback;

class Forwarding
{
    /**
     * Forwards a feedback comment if needed
     * @param  int $answerId
     * @param  int $postId
     * @param  string $comment  The comment text
     * @param  string $email    The email address belonging to the comment
     * @return void
     */
    public static function maybeForward($answerId, $postId, $comment, $email, $topicId)
    {
        $toGlobal = get_field('feedback_forwarding', 'option');
        $toLocal = get_field('feedback_forwarding', $postId);

        if (!is_array($toGlobal)) {
            $toGlobal = array();
        }

        if (!is_array($toLocal)) {
            $toLocal = array();
        }

        $to = array_merge($toGlobal, $toLocal);

        if (empty($to)) {
            return;
        }

        $toDef = $to;
        $to = array();
        foreach ($toDef as $item) {
            $to[] = $item['email_address'];
        }

        $subject = get_field('email_subject', 'option') ? get_field('email_subject', 'option') : __('Feedback', 'customer-feedback');
        $message = get_field('email_lead_message', 'option') ? get_field('email_lead_message', 'option') : __('Hey, you\'ve got new feedback!', 'customer-feedback');

        $topic = '';
        if ($topicId) {
            $topic = get_term($topicId, 'feedback_topic');
            $topic = '<br><br>' . __('Topic', 'customer-feedback') . ': ' . $topic->name;
        }

        $message .= $topic;
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
