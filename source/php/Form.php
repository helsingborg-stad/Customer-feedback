<?php

namespace CustomerFeedback;

use Throwable;
use ComponentLibrary\Init as ComponentLibraryInit;
use WP_Post;
class Form
{
    public function __construct()
    {
        add_action('customer-feedback', array($this, 'appendForm'));
    }

    /**
     * Appends the "did you find what you are looking for"
     * form to the bottom of the content if inside the main loop and content has characters
     * @param  string $content The original content
     * @return string          The original content with form appended to bottom
     */
    public function appendForm()
    {
        global $post;

        if(!is_a($post, 'WP_Post')) {
            return;
        }

        $allowedPostTypes = apply_filters('CustomerFeedback/post_types', get_field('customer_feedback_posttypes', 'option'));
        if (is_null($allowedPostTypes)) {
            $allowedPostTypes = array('page');
        }

        if (!is_array($allowedPostTypes) || !in_array($post->post_type ?? null, $allowedPostTypes)) {
            return;
        }

        $postExtended = get_extended($post->post_content);

        $mainQuestion = __('Did the information on this page help you?', 'customer-feedback');
        if (!empty(get_field('customer_feedback_main_question_text', 'option'))) {
            $mainQuestion = get_field('customer_feedback_main_question_text', 'option');
        }

        $mainQuestionSub = __('Answer the question to help us improve our information.', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_main_question_sub', 'option'))) {
            $mainQuestionSub = get_field('customer_feedback_main_question_sub', 'option');
        }

        $negativeLabel = __('How can we make the information better?', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_feedback_label_no', 'option'))) {
            $negativeLabel = get_field('customer_feedback_feedback_label_no', 'option');
        }

        $positiveLabel = __('Comment', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_feedback_label_yes', 'option'))) {
            $positiveLabel = get_field('customer_feedback_feedback_label_yes', 'option');
        }

        $commentExplain = __('Note that your comment will become public act.', 'customer-feedback');
        $emailLabel = __('Email address', 'customer-feedback');
        $emailExplain = __('Please give us your email address to get a reply on your feedback.', 'customer-feedback');
        $addComment = __('Please complete your feedback by selecting a category and entering a comment.', 'customer-feedback');

        $thanksText = __('Thank you', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_thanks', 'option'))) {
            $thanksText = get_field('customer_feedback_thanks', 'option');
        }

        $userEmail = null;
        if (is_user_logged_in()) {
            $userdata = get_userdata(get_current_user_id());
            $userEmail = $userdata->user_email;
        }

        $topics = get_terms( array(
            'taxonomy' => 'feedback_topic',
            'hide_empty' => false,
        ));

        $topicLabel = __('Topic', 'customer-feedback');
        if (function_exists('get_field') && !empty(get_field('customer_feedback_label_topic', 'option'))) {
            $topicLabel = get_field('customer_feedback_label_topic', 'option');
        }

        if (!empty($topics)) {
            foreach ($topics as $topic) {
                $topic->description = trim($topic->description);
                $topic->feedback_capability = get_field('topic_feedback_capability', 'feedback_topic_' . $topic->term_id);
            }
        }
        $gdpr = !empty(get_field('gdpr_complience_notice', 'option'));
        if ($gdpr !== false) {
            $gdpr_complience_notice_content = get_field('gdpr_complience_notice_content', 'option');
        }

        $formData = $this->getFormData();

      

        echo $this->renderView('form', $formData);

        echo '<pre>'; 
            print_r($formData);
        echo '</pre>';

        include CUSTOMERFEEDBACK_TEMPLATE_PATH . 'form.php';
    }

    /**
     * Get form data
     * 
     * @return array
     */
    public function getFormData(): array
    {
        global $post;

        if (!is_a($post, 'WP_Post')) {
            return [];
        }

        // Get allowed post types
        $allowedPostTypes = apply_filters('CustomerFeedback/post_types', get_field('customer_feedback_posttypes', 'option')) ?: ['page'];

        if (!in_array($post->post_type ?? null, (array) $allowedPostTypes, true)) {
            return [];
        }

        // Fetch form labels and text fields
        $getField = function ($key, $default = '', $postId = 'option') {
            return function_exists('get_field') && !empty(get_field($key, $postId)) ? get_field($key, $postId) : $default;
        };

        $formData = [
            'mainQuestion'      => $getField('customer_feedback_main_question_text', __('Did the information on this page help you?', 'customer-feedback')),
            'mainQuestionSub'   => $getField('customer_feedback_main_question_sub', __('Answer the question to help us improve our information.', 'customer-feedback')),
            'labels'            => (object) [
                'negative'          => $getField('customer_feedback_feedback_label_no', __('Yes', 'customer-feedback')),
                'positive'          => $getField('customer_feedback_feedback_label_yes', __('No', 'customer-feedback')),
                'comment_explain'   => __('Note that your comment will become public act.', 'customer-feedback'),
                'email'             => __('Email address', 'customer-feedback'),
                'email_explain'     => __('Please give us your email address to get a reply on your feedback.', 'customer-feedback'),
                'add_comment'       => __('Please complete your feedback by selecting a category and entering a comment.', 'customer-feedback'),
                'success'           => __('Thank you', 'customer-feedback'),
                'error'             => __('Something went wrong, please try again later. Could not store your response.', 'customer-feedback'),
                'alreadysubmitted'  => __('You have already given feedback for this content.', 'customer-feedback'),
            ],
            'submittedText'      => $getField('customer_feedback_thanks', ''),
            'user_email'         => is_user_logged_in() ? get_userdata(get_current_user_id())->user_email : null,
            'topics'             => [],
            'topic'              => (object) [
                'heading'     => $getField('customer_feedback_label_topic', __('Topic', 'customer-feedback')),
                'description' => $getField('customer_feedback_label_topic_description', __('Select a topic that best describes your feedback.', 'customer-feedback')),
            ],
            'gdpr'               => (object) [
                'enabled' => !empty($getField('gdpr_complience_notice')),
                'content' => $getField('gdpr_complience_notice_content') ?: '',
            ],
        ];

        // Fetch topics
        $topics = get_terms([
            'taxonomy'   => 'feedback_topic',
            'hide_empty' => false,
        ]);

        if(!empty($topics)) {
            foreach ($topics as $topic) {
                $formData['topics'][] = (object) [
                    'id'                    => $topic->term_id,
                    'name'                  => $topic->name,
                    'description'           => $topic->description,
                    'feedback_capability'   => $getField('topic_feedback_capability', '', 'feedback_topic_' . $topic->term_id) ?: '',
                ];
            }
        }

        return $formData;
    }

    /**
     * Render view
     * 
     * @param string $view
     * @param array $data
     * @return mixed
     */
    public function renderView($view, $data = array()): mixed
    {
        $blade = $this->getBladeEngine();

        if(!$blade) {
            return false;
        }

        try {
            return $blade->makeView($view, $data, [], [
                constant('CUSTOMERFEEDBACK_TEMPLATE_PATH'),
            ])->render();
        } catch (Throwable $e) {
           $blade->errorHandler($e)->print();
        }

        return false;
    }

    /**
     * Get blade engine 
     * 
     * @return Blade
     */
    private function getBladeEngine()
    {
        if(!class_exists(ComponentLibraryInit::class)) {
            return false;
        }
        return (new ComponentLibraryInit([]))->getEngine();
    }
}
