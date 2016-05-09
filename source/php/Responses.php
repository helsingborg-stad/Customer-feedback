<?php

namespace CustomerFeedback;

class Responses
{
    public $postTypeSlug = 'customer-feedback';

    public function __construct()
    {
        add_action('init', array($this, 'registerPostType'));

        // Set comment field as readonly
        add_action('acf/load_field/name=customer_feedback_comment', function ($field) {
            $field['readonly'] = 1;
            return $field;
        });

        // Submit response ajax
        add_action('wp_ajax_submit_response', array($this, 'submitResponse'));
        add_action('wp_ajax_nopriv_submit_response', array($this, 'submitResponse'));

        // Submit comment ajax
        add_action('wp_ajax_submit_comment', array($this, 'submitComment'));
        add_action('wp_ajax_nopriv_submit_comment', array($this, 'submitComment'));

        // List table columns
        add_filter('manage_edit-' . $this->postTypeSlug . '_columns', array($this, 'listColumns'));
        add_action('manage_' . $this->postTypeSlug . '_posts_custom_column', array($this, 'listColumnsContent'), 10, 2);
        add_filter('manage_edit-' . $this->postTypeSlug . '_sortable_columns', array($this, 'listColumnsSorting'));

        // Add page link metabox
        add_action('add_meta_boxes', array($this, 'addMetaBoxes'));

        // Add page metaboxes
        add_action('add_meta_boxes', array($this, 'addPageSummaryMetaBox'), 10, 2);
    }

    public function addPageSummaryMetaBox($postType, $post)
    {
        global $wpdb;
        $answers = $wpdb->get_results("
            SELECT pm2.meta_value AS answer, COUNT(pm2.meta_value) AS count FROM {$wpdb->postmeta} pm1
            LEFT OUTER JOIN {$wpdb->postmeta} pm2 ON pm1.post_id = pm2.post_id
            WHERE
                pm1.meta_key = 'customer_feedback_page_reference'
                AND pm1.meta_value = {$post->ID}
                AND pm2.meta_key = 'customer_feedback_answer'
            GROUP BY pm2.meta_value
            ORDER BY count DESC
        ");

        if (count($answers) === 0) {
            return;
        }

        add_meta_box('customer-feedback-summary-meta', 'Customer feedback summary', array($this, 'renderSummary'), $postType, 'advanced', 'default', array(
            'results' => $answers
        ));
    }

    public function renderSummary($postId, $data)
    {
        $totalCount = 0;
        echo '<table id="customer-feedback-summary" cellspacing="0" cellpadding="0"><tbody>';

        foreach ($data['args']['results'] as $answer) {
            $totalCount += $answer->count;
        }

        foreach ($data['args']['results'] as $answer) {
            $answerLabel = false;

            switch ($answer->answer) {
                case 'yes':
                    $answerLabel = '<span style="color:#30BA41;">' . __('Positive', 'customer-feedback') . '</span>';
                    break;

                case 'no':
                    $answerLabel = '<span style="color:#BA3030;">' . __('Negative', 'customer-feedback') . '</span>';
                    break;
            }

            if (!$answerLabel) {
                continue;
            }

            echo '
                <tr>
                    <td>' . $answerLabel . '</td>
                    <td>' . round($answer->count / $totalCount, 2) * 100 . '%</td>
                </tr>
            ';
        }

        echo '</tbody></table>';
    }

    /**
    * Registers a new post type
    * @uses $wp_post_types Inserts new post type object into the list
    *
    * @param string  Post type key, must not exceed 20 characters
    * @param array|string  See optional args description above.
    * @return object|WP_Error the registered post type object, or an error object
    */
    public function registerPostType()
    {
        $nameSingular = 'Feedback';
        $namePlural = 'Feedback';
        $description = 'Create shortlinks to your posts or pages';

        $labels = array(
            'name'               => _x($nameSingular, 'post type general name', 'customer-feedback'),
            'singular_name'      => _x($nameSingular, 'post type singular name', 'customer-feedback'),
            'menu_name'          => _x($namePlural, 'admin menu', 'customer-feedback'),
            'name_admin_bar'     => _x($nameSingular, 'add new on admin bar', 'customer-feedback'),
            'add_new'            => _x('Add New', 'add new button', 'customer-feedback'),
            'add_new_item'       => sprintf(__('Add new %s', 'customer-feedback'), $nameSingular),
            'new_item'           => sprintf(__('New %s', 'customer-feedback'), $nameSingular),
            'edit_item'          => sprintf(__('Edit %s', 'customer-feedback'), $nameSingular),
            'view_item'          => sprintf(__('View %s', 'customer-feedback'), $nameSingular),
            'all_items'          => sprintf(__('All %s', 'customer-feedback'), $namePlural),
            'search_items'       => sprintf(__('Search %s', 'customer-feedback'), $namePlural),
            'parent_item_colon'  => sprintf(__('Parent %s', 'customer-feedback'), $namePlural),
            'not_found'          => sprintf(__('No %s', 'customer-feedback'), $namePlural),
            'not_found_in_trash' => sprintf(__('No %s in trash', 'customer-feedback'), $namePlural)
        );

        $args = array(
            'labels'               => $labels,
            'description'          => __($description, 'customer-feedback'),
            'public'               => false,
            'publicly_queriable'   => false,
            'show_ui'              => true,
            'show_in_nav_menus'    => false,
            'show_in_menu'         => true,
            'has_archive'          => false,
            'rewrite'              => false,
            'hierarchical'         => false,
            'menu_position'        => 100,
            'exclude_from_search'  => true,
            'menu_icon'            => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MTIiIGhlaWdodD0iNTEyIiB2aWV3Qm94PSIwIDAgNDY5Ljg2MiA0NjkuODYzIj48ZyBmaWxsPSIjRkZGIj48cGF0aCBkPSJNNDQ3LjYzMyAzOS41MzdoLTE5MS4xOWMtMTIuMjYgMC0yMi4yMzIgOS45NzItMjIuMjMyIDIyLjIzdjk4LjY1MmMwIDEyLjI1NyA5Ljk3NCAyMi4yMjggMjIuMjMzIDIyLjIyOGgxNi43ODd2MzkuMTZhNi45MiA2LjkyIDAgMCAwIDExLjQ0MiA1LjIzNWw1MS4zOC00NC4zOTZoMTExLjU4YzEyLjI1NyAwIDIyLjIzLTkuOTczIDIyLjIzLTIyLjIzdi05OC42NWMwLTEyLjI1OC05Ljk3LTIyLjIzLTIyLjIzLTIyLjIzek0yOTYuNjg2IDEyNy40NWMtOS43NDMgMC0xNy42NDItNy45LTE3LjY0Mi0xNy42NDRzNy44OTctMTcuNjQ0IDE3LjY0Mi0xNy42NDRjOS43NDYgMCAxNy42NDYgNy45IDE3LjY0NiAxNy42NDQtLjAwMiA5Ljc0My03LjkgMTcuNjQ0LTE3LjY0NiAxNy42NDR6bTU1LjM1IDBjLTkuNzQgMC0xNy42NDMtNy45LTE3LjY0My0xNy42NDRzNy45LTE3LjY0NCAxNy42NDQtMTcuNjQ0YzkuNzQ0IDAgMTcuNjQ1IDcuOSAxNy42NDUgMTcuNjQ0IDAgOS43NDMtNy45IDE3LjY0NC0xNy42NDUgMTcuNjQ0em01NS4zNTUgMGMtOS43NDIgMC0xNy42NDItNy45LTE3LjY0Mi0xNy42NDRzNy44OTgtMTcuNjQ0IDE3LjY0My0xNy42NDRjOS43NDYgMCAxNy42NDUgNy45IDE3LjY0NSAxNy42NDQtLjAwMiA5Ljc0My03LjkwMiAxNy42NDQtMTcuNjQ0IDE3LjY0NHpNMTQwLjg1NyAxMzQuOTU4Yy00My4wOTMgMC02Ni45NCAyMi4zMy02Ni41MDYgNjUuMzU4LjYzMiA1OC45MzIgMjUuNjc0IDk0LjY4MiA2Ni41MDcgOTQuMDU4IDAgMCA2Ni40NzMgMi42OTUgNjYuNDczLTk0LjA1OCAwLTQzLjAyOC0yMi40NTctNjUuMzU4LTY2LjQ3My02NS4zNTh6TTI1OC40MzQgMzM5LjEwM2wtNjYuNDItMjYuNDgtMTUuNTUzLTEzLjEwN2ExMC4zNSAxMC4zNSAwIDAgMC0xMy45ODUuNTc0bC0yMS42MjQgMjEuNTA0LTIxLjY4Ny0yMS41MWExMC4zNTYgMTAuMzU2IDAgMCAwLTEzLjk3NS0uNTY3bC0xNS41NTYgMTMuMTA2LTY2LjQyMyAyNi40ODRDMS44MiAzNDcuNjI3IDEuODM1IDQyMy4zNyAwIDQzMC4zMjdoMjgxLjY3NGMtMS44MzItNi45NC0xLjg0My04Mi43MTItMjMuMjQtOTEuMjI0eiIvPjwvZz48L3N2Zz4=',
            'supports'             => array('title')
        );

        register_post_type($this->postTypeSlug, $args);
    }

    public function addMetaBoxes($postType)
    {
        if ($postType != $this->postTypeSlug) {
            return;
        }

        add_meta_box('customer-feedback-page-url', 'Page', array($this, 'pageMetaBoxContent'), $this->postTypeSlug, 'advanced', 'high');
    }

    public function pageMetaBoxContent()
    {
        global $post;

        $parent = get_post_meta($post->ID, 'customer_feedback_page_reference', true);
        $parent = get_post($parent);

        echo '<p><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> (' . get_permalink($parent) . ')</p>';
    }

    /**
     * Setup list table columns
     * @param  array $columns The original columns
     * @return array          The modified columns
     */
    public function listColumns($columns)
    {
        $columns = array(
            'cb'     => '<input type="checkbox">',
            'title'  => __('Page', 'customer-feedback'),
            'answer' => __('Answer', 'customer-feedback'),
            'hasComment'   => __('Has comment', 'customer-feedback'),
            'date'   => __('Date')
        );

        return $columns;
    }

    /**
     * Add content to list table columns
     * @param  string  $column Column slug
     * @param  integer $postId Post id
     * @return void
     */
    public function listColumnsContent($column, $postId)
    {
        switch ($column) {
            case 'answer':
                if (get_post_meta($postId, 'customer_feedback_answer', true) == 'no') {
                    echo '<span style="color:#BA3030;">' . __('No') . '</span>';
                } elseif (get_post_meta($postId, 'customer_feedback_answer', true) == 'yes') {
                    echo '<span style="color:#30BA41;">' . __('Yes') . '</span>';
                }
                break;

            case 'hasComment':
                echo (!empty(get_field('customer_feedback_comment', $postId))) ? __('Yes') : __('No');
                break;
        }
    }

    /**
     * Setup list table sorting
     * @param  array $columns  Sortable columns
     * @return array           Modified sortable columns
     */
    public function listColumnsSorting($columns)
    {
        $columns['answer'] = 'answer';
        $columns['hasComment'] = 'hasComment';
        return $columns;
    }

    /**
     * Saves the "Yes" or "No" response as counters in metadata
     * @return integer The last inserted id from db
     */
    public function submitResponse()
    {
        $insertedId = 'false';
        $postId = (isset($_POST['postid']) && is_numeric($_POST['postid'])) ? $_POST['postid'] : null;
        $answer = (isset($_POST['answer']) && strlen($_POST['answer']) > 0) ? $_POST['answer'] : null;

        if ($postId && $answer) {
            $insertedId = wp_insert_post(array(
                'post_type' => $this->postTypeSlug,
                'post_status' => 'publish',
                'post_title' => get_the_title($postId)
            ));

            update_post_meta($insertedId, 'customer_feedback_page_reference', $postId);
            update_post_meta($insertedId, 'customer_feedback_ip', $_SERVER['REMOTE_ADDR']);
            update_post_meta($insertedId, 'customer_feedback_answer', $answer);
        }

        echo $insertedId;
        wp_die();
    }

    /**
     * Save a comment response as metadata for the page commented on
     * @return string Always returns "true" as a string
     */
    public function submitComment()
    {
        $answerId = (isset($_POST['answerid']) && is_numeric($_POST['answerid'])) ? $_POST['answerid'] : null;
        $postId = (isset($_POST['postid']) && is_numeric($_POST['postid'])) ? $_POST['postid'] : null;
        $comment = (isset($_POST['comment']) && strlen($_POST['comment']) > 0) ? $_POST['comment'] : null;
        $commentType = (isset($_POST['commenttype']) && strlen($_POST['commenttype']) > 0) ? $_POST['commenttype'] : null;

        if ($answerId && $postId) {
            update_post_meta($answerId, 'customer_feedback_comment', $comment);
            update_post_meta($answerId, 'customer_feedback_comment_type', $commentType);

            echo 'true';
        } else {
            echo 'false';
        }

        wp_die();
    }
}
