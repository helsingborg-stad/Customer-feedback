<?php

namespace CustomerFeedback;

class NeedsAttention extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct([
            'singular' => __('Post', 'customer-feedback'),
            'plural'   => __('Posts', 'customer-feedback'),
            'ajax'     => false
        ]);
    }

    public function getPosts()
    {
        global $wpdb;

        $returnPosts = array();
        $posts = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->posts} AS posts
            INNER JOIN {$wpdb->postmeta} AS pm1 ON pm1.meta_value = posts.ID
            WHERE
                posts.post_status = 'publish'
                AND pm1.meta_key = 'customer_feedback_page_reference'
                AND posts.post_type != 'customer-feedback'
            GROUP BY posts.ID
        ");

        foreach ($posts as $post) {
            $responsesCount = array_sum(Responses::getResponses($post->ID));
            if ($responsesCount < 5) {
                continue;
            }

            $responses = Responses::getResponses($post->ID, 'percent');

            if ($responses['no'] < 30) {
                continue;
            }

            $post->responses = $responses;
            $returnPosts[] = $post;
        }

        return $returnPosts;
    }

    public function no_items()
    {
        return __('There\'s no posts that needs attention right now', 'customer-feedback');
    }

    public function prepare_items()
    {
        $items = $this->getPosts();

        // Columns
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);

        // Pagination
        $this->set_pagination_args(array(
            'total_items' => count($items),
            'per_page'    => 10,
            'total_pages' => ceil(count($items)/10)
        ));

        // Items
        $this->items = $items;
    }

    public function get_columns()
    {
        return array(
            'title' => __('Title'),
            'negative' => __('Negative', 'customer-feedback'),
            'positive' => __('Positive', 'customer-feedback')
        );
    }

    public function column_title($item)
    {
        return edit_post_link($item->post_title, '<strong>', '</strong>', $item->ID);
    }

    public function column_positive($item)
    {
        $responses = $item->responses;
        $responsesCount = Responses::getResponses($item->ID);

        foreach ($responses as $key => $response) {
            if ($key != 'yes') {
                continue;
            }

            return '<span style="color:#30BA41;">' . round($response, 2) . '% (' . $responsesCount[$key] . ')</span>';
        }

        return 'n/a';
    }

    public function column_negative($item)
    {
        $responses = $item->responses;
        $responsesCount = Responses::getResponses($item->ID);

        foreach ($responses as $key => $response) {
            if ($key != 'no') {
                continue;
            }

            return '<span style="color:#BA3030;">' . round($response, 2) . '% (' . $responsesCount[$key] . ')</span>';
        }

        return 'n/a';
    }
}
