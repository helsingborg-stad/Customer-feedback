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
     * form to the bottom of the content if inside the main loop
     */
    public function appendForm(): void
    {
        if (!$this->shouldRenderForm()) {
            return;
        }
        echo $this->renderView('form', $this->getFormData());
    }

    /**
     * Check if form should be rendered
     * 
     * @return bool
     */
    private function shouldRenderForm(): bool
    {
        global $post;

        if (!is_a($post, 'WP_Post')) {
            return false;
        }

        $allowedPostTypes = apply_filters('CustomerFeedback/post_types', get_field('customer_feedback_posttypes', 'option'));
        if (is_null($allowedPostTypes)) {
            $allowedPostTypes = array('page');
        }

        if (!is_array($allowedPostTypes) || !in_array($post->post_type ?? null, $allowedPostTypes)) {
            return false;
        }

        return true;
    }

    /**
     * Get form data
     * 
     * @return array
     */
    public function getFormData(): array
    {

        // Fetch form labels and text fields
        $getField = function ($key, $default = '', $postId = 'option') {
            return function_exists('get_field') && !empty(get_field($key, $postId)) ? get_field($key, $postId) : $default;
        };

        $formData = [
            'question' => (object) [
                'title' => $getField('customer_feedback_main_question_text', __('Did the information on this page help you?', 'customer-feedback')),
                'description' => $getField('customer_feedback_main_question_sub', __('Answer the question to help us improve our information.', 'customer-feedback')),
            ],
            'labels' => (object) [
                
                'negative'          => $getField('customer_feedback_feedback_label_no', __('No', 'customer-feedback')),
                'positive'          => $getField('customer_feedback_feedback_label_yes', __('Yes', 'customer-feedback')),
                
                'comment' => (object) [
                    'label'         => __('How can we make the information better?', 'customer-feedback'),
                    'explain'       => false,
                    'placeholder'   => false,
                    'error'         => __('Please enter a comment of minimum 15 characters.', 'customer-feedback'),
                ],

                'email' => (object) [
                    'label'         => __('Email address', 'customer-feedback'),
                    'explain'       => false,
                    'error'        => __('Please enter a valid email address.', 'customer-feedback'),
                    'placeholder'  => __('email@example.com', 'customer-feedback'),
                ],

                'notification' => (object) [
                    'success'           => $getField('customer_feedback_thanks', __('Thank you', 'customer-feedback')),
                    'error'             => __('Something went wrong, please try again later. Could not store your response.', 'customer-feedback'),
                    'alreadysubmitted'  => __('You have already given feedback for this content.', 'customer-feedback'),
                ],  

                'topic' => (object) [
                    'heading'     => $getField('customer_feedback_label_topic', __('Topic', 'customer-feedback')),
                    'description' => strip_tags(
                        $getField('customer_feedback_label_topic_description', __('Please complete your feedback by selecting a category and entering a comment.', 'customer-feedback'))
                    , '<a>'),
                ],

                'submit' => __('Submit', 'customer-feedback'),
            ],
            'userEmail'          => is_user_logged_in() ? get_userdata(get_current_user_id())->user_email : null,
            'topics'             => [],
            'gdpr'               => (object) [
                'enabled' => !empty($getField('gdpr_complience_notice')),
                'content' => strip_tags($getField('gdpr_complience_notice_content') ?: '', '<a>')
            ],
            'postId'    => $this->getCurrentPostId(),
            'frequency' => (int) $getField('customer_feedback_feedback_frequency', 0, 'option'),
        ];

        // Fetch topics
        $topics = get_terms([
            'taxonomy'   => 'feedback_topic',
            'hide_empty' => false,
        ]);

        if(!empty($topics)) {
            foreach ($topics as $topic) {
                $formData['topics'][] = (object) [
                    'id'                        => $topic->term_id,
                    'name'                      => $topic->name,
                    'description'               => $topic->description,
                    'feedbackCapability'        => $getField('topic_feedback_capability', '', 'feedback_topic_' . $topic->term_id) ?: '0',
                    'feedbackCapabilityEmail'   => $getField('topic_feedback_capability_email', '', 'feedback_topic_' . $topic->term_id) ?: '0',
                ];
            }
        }

        // Add json data
        $formData['jsonData'] = json_encode($formData);

        return $formData;
    }

    /**
     * Get current post id
     * 
     * @return int
     */
    private function getCurrentPostId(): int
    {
        global $post;
        return is_a($post, WP_Post::class) ? $post->ID : 0;
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
