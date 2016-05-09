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

        foreach ($posts as $key => $post) {
            $responses = Responses::getResponses($post->ID);

            $totalCount = 0;
            $responseShare = array();

            foreach ($responses as $response) {
                $totalCount += $response->count;
            }

            foreach ($responses as $response) {
                $responseShare[$response->answer] = round($response->count / $totalCount, 2) * 100;
            }

            if ($responseShare['no'] < 30) {
                unset($posts[$key]);
                continue;
            }

            $post->responses = $responses;
        }

        return $posts;
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
        $totalCount = 0;

        foreach ($responses as $response) {
            $totalCount += $response->count;
        }

        foreach ($responses as $response) {
            if ($response->answer != 'yes') {
                continue;
            }

            return '<span style="color:#30BA41;">' . round($response->count / $totalCount, 2) * 100 . '%</span>';
        }

        return 'n/a';
    }

    public function column_negative($item)
    {
        $responses = $item->responses;
        $totalCount = 0;

        foreach ($responses as $response) {
            $totalCount += $response->count;
        }

        foreach ($responses as $response) {
            if ($response->answer != 'no') {
                continue;
            }

            return '<span style="color:#BA3030;">' . round($response->count / $totalCount, 2) * 100 . '%</span>';
        }

        return 'n/a';
    }
}
