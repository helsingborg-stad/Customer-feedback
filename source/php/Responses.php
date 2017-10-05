<?php

namespace CustomerFeedback;

class Responses
{
    public $postTypeSlug = 'customer-feedback';

    public function __construct()
    {
        add_action('init', array($this, 'registerPostType'));
        add_action('init', array($this, 'registerTaxonomy'));

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

        add_action('pre_get_posts', array($this, 'listColumnsSortingQuery'), 15);
        add_action('restrict_manage_posts', array($this, 'listFilters'), 10, 2);
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

    /**
     * Register a 'topic' taxonomy for post type 'customer-feedback'.
     */
    public function registerTaxonomy() {
        $namePlural = __('Topics', 'customer-feedback');
        $nameSingular = __('Topic', 'customer-feedback');

        $labels = array(
            'name'              => $namePlural,
            'singular_name'     => $nameSingular,
            'search_items'      => sprintf(__('Search %s', 'customer-feedback'), $namePlural),
            'all_items'         => sprintf(__('All %s', 'customer-feedback'), $namePlural),
            'parent_item'       => sprintf(__('Parent %s:', 'customer-feedback'), $nameSingular),
            'parent_item_colon' => sprintf(__('Parent %s:', 'customer-feedback'), $nameSingular) . ':',
            'edit_item'         => sprintf(__('Edit %s', 'customer-feedback'), $nameSingular),
            'update_item'       => sprintf(__('Update %s', 'customer-feedback'), $nameSingular),
            'add_new_item'      => sprintf(__('Add New %s', 'customer-feedback'), $nameSingular),
            'new_item_name'     => sprintf(__('New %s Name', 'customer-feedback'), $nameSingular),
            'menu_name'         => $nameSingular,
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'meta_box_cb'       => false,
            'rewrite'           => array('slug' => 'topic'),
        );

        register_taxonomy('feedback_topic', array($this->postTypeSlug), $args);
    }

    /**
     * Get the yes/no response count
     * @param  int    $postId   Post
     * @param  string $type     Count or percent
     * @return array
     */
    public static function getResponses($postId, $type = 'count')
    {
        $answers = array('no' => 0, 'yes' => 0);
        $modDate = get_the_modified_date('Y-m-d H:i:s', $postId);

        // Get answer posts
        $answerPosts = new \WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'customer-feedback',
            'post_status' => array('publish', 'pending', 'draft'),
            'date_query' => array(
                array(
                    'after'  => $modDate,
                    'inclusive' => true
                ),
            ),
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'customer_feedback_page_reference',
                    'value' => $postId,
                    'comare' => '='
                )
            )
        ));

        // Get answer meta
        foreach ($answerPosts->posts as $item) {
            $answers[get_post_meta($item->ID, 'customer_feedback_answer', true)]++;
        }

        arsort($answers);

        if ($type === 'percent') {
            $total = array_sum($answers);

            $answers = array_map(function ($item) use ($total) {
                if ($total === 0) {
                    return 0;
                }

                return ($item / $total) * 100;
            }, $answers);
        }

        return $answers;
    }

    /**
     * Add meta boxes
     */
    public function addMetaBoxes($postType)
    {
        if ($postType != $this->postTypeSlug) {
            return;
        }

        add_meta_box('customer-feedback-page-url', 'Page', array($this, 'pageMetaBoxContent'), $this->postTypeSlug, 'advanced', 'high');
    }

    /**
     * Answer page parent metabox
     * @return void
     */
    public function pageMetaBoxContent()
    {
        global $post;

        $parent = get_post_meta($post->ID, 'customer_feedback_page_reference', true);
        $parent = get_post($parent);

        echo '<p><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> (' . get_permalink($parent) . ')</p>';
    }

    /**
     * Display summary metabox
     * @param string $postType Post type
     * @param object $post     Current post
     */
    public function addPageSummaryMetaBox($postType, $post)
    {
        $allowedPostTypes = get_field('customer_feedback_posttypes', 'option');

        if (!isset($post->ID) || (is_array($allowedPostTypes) && !in_array($postType, $allowedPostTypes))) {
            return;
        }

        $answers = Responses::getResponses($post->ID);

        if (count($answers) === 0) {
            return;
        }

        add_meta_box(
            'customer-feedback-summary-meta',
            __('Customer feedback summary', 'customer-feedback') . ' (' . __('since', 'customer-feedback') . ' ' . get_the_modified_date('Y-m-d H:i') . ')',
            array($this, 'renderSummary'),
            $postType,
            'side',
            'default',
            array(
                'results' => $answers
            )
        );
    }

    /**
     * Content of summary metabox
     * @param  integer $postId Current post id
     * @param  array   $data   Metabox args
     * @return void
     */
    public function renderSummary($postId, $data)
    {
        $totalCount = 0;
        echo '<table id="customer-feedback-summary" cellspacing="0" cellpadding="0"><tbody>';

        foreach ($data['args']['results'] as $count) {
            $totalCount += $count;
        }

        foreach ($data['args']['results'] as $answer => $count) {
            $answerLabel = false;

            switch ($answer) {
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

            $percent = 0;
            if ($totalCount > 0) {
                $percent = round($count / $totalCount, 2) * 100;
            }

            echo '
                <tr>
                    <td>' . $answerLabel . '</td>
                    <td>' . $percent . '% (' . $count . ')</td>
                </tr>
            ';
        }

        echo '</tbody></table>';

        echo '<div style="padding:12px 14px;">' . __('The feedback stats will be reset to zero (without removing the actual feedback messages) when a new version of the post is saved.', 'customer-feedback') . '</div>';
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
            'topic' => __('Topic', 'customer-feedback'),
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
            case 'topic':
                $topics = wp_get_post_terms($postId, 'feedback_topic');
                if (!empty($topics)) {
                    foreach ($topics as $key => $topic) {
                        echo ($key == 0) ? $topic->name : ', ' . $topic->name;
                    }
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
        $columns['hasComment'] = 'has-comment';

        return $columns;
    }

    /**
     * Handles the sorting of the table columns
     * @param  WP_Query $query
     * @return void
     */
    public function listColumnsSortingQuery($query)
    {
        if (!is_admin() || !$query->is_main_query() || $query->get('post_type') != $this->postTypeSlug) {
            return;
        }

        if (!empty($_GET['feedback_topic'])) {
            $query->set('tax_query', array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'feedback_topic',
                    'field' => 'slug',
                    'terms' => $_GET['feedback_topic'],
                    'operator' => 'IN'
                )
            ));
        }

        $metaQuery = array(
            'relation' => 'AND'
        );

        // Filter on has-comment
        if (isset($_GET['has-comment']) && $_GET['has-comment'] === 'yes') {
            $metaQuery[] = array(
                'key' => 'customer_feedback_comment',
                'compare' => 'EXISTS'
            );
        }

        if (isset($_GET['has-comment']) && $_GET['has-comment'] === 'no') {
            $metaQuery[] = array(
                'key' => 'customer_feedback_comment',
                'compare' => 'NOT EXISTS'
            );
        }

        if (!isset($_GET['has-comment']) || empty($_GET['has-comment'])) {
            $metaQuery[] = array(
                'relation' => 'OR',
                array(
                    'key' => 'customer_feedback_comment',
                    'compare' => 'EXISTS'
                ),
                array(
                    'key' => 'customer_feedback_comment',
                    'compare' => 'NOT EXISTS'
                )
            );
        }


        // Filter on answer
        if (isset($_GET['answer']) && $_GET['answer'] === 'yes') {
            $metaQuery[] = array(
                'relation' => 'OR',
                array(
                    'key' => 'customer_feedback_answer',
                    'value' => 'yes',
                    'compare' => '='
                )
            );
        }

        if (isset($_GET['answer']) && $_GET['answer'] === 'no') {
            $metaQuery[] = array(
                'relation' => 'OR',
                array(
                    'key' => 'customer_feedback_answer',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => 'customer_feedback_answer',
                    'value' => 'no',
                    'compare' => '='
                )
            );
        }

        $query->set('meta_query', $metaQuery);

        switch ($query->get('orderby')) {
            case 'has-comment':
                $query->set('orderby', 'customer_feedback_comment');
                break;

            case 'answer':
                $query->set('orderby', 'customer_feedback_answer');
                break;
        }
    }

    public function listFilters($postType, $where = null)
    {
        if ($postType !== $this->postTypeSlug || $where !== 'top') {
            return;
        }

        echo '<select name="answer">
            <option value="">' . __('Answer', 'customer-feedback') . '</option>
            <option value="no" ' . selected(true, isset($_GET['answer']) && $_GET['answer'] === 'no', false) . '>' . __('No') . '</option>
            <option value="yes" ' . selected(true, isset($_GET['answer']) && $_GET['answer'] === 'yes', false) . '>' . __('Yes') . '</option>
        </select>';

        echo '<select name="has-comment">
            <option value="">' . __('Has comment', 'customer-feedback') . '</option>
            <option value="no" ' . selected(true, isset($_GET['has-comment']) && $_GET['has-comment'] === 'no', false) . '>' . __('No') . '</option>
            <option value="yes" ' . selected(true, isset($_GET['has-comment']) && $_GET['has-comment'] === 'yes', false) . '>' . __('Yes') . '</option>
        </select>';

        // Filter by feedback topics
        $topics = get_terms( array(
            'taxonomy' => 'feedback_topic',
            'hide_empty' => false,
        ));
        echo '<select name="feedback_topic"><option value="">' . __('All topics', 'customer-feedback') . '</option>';
        foreach ($topics as $topic) {
            echo '<option value="' . $topic->slug . '" ' . selected(true, isset($_GET['feedback_topic']) && $_GET['feedback_topic'] == $topic->slug, false) . '>' . $topic->name . '</option>';
        }
        echo '</select>';

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

        $cookieExpireDays = 5;
        $cookieExpire = time() + (86400 * $cookieExpireDays);

        if (!isset($_COOKIE['customer-feedback'])) {
            setcookie('customer-feedback', serialize(array($postId)), $cookieExpire, COOKIEPATH, COOKIE_DOMAIN);
        } else {
            if (in_array($postId, unserialize(stripslashes($_COOKIE['customer-feedback'])))) {
                echo 'cookie_error';
                wp_die();
            }

            $cookieVal = unserialize($_COOKIE['customer-feedback']);
            $cookieVal[] = $postId;
            setcookie('customer-feedback', serialize($cookieVal), $cookieExpire, COOKIEPATH, COOKIE_DOMAIN);
        }

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
        $email = (isset($_POST['email']) && strlen($_POST['email']) > 0) ? $_POST['email'] : null;
        $topicId = (isset($_POST['topicid']) && is_numeric($_POST['topicid'])) ? (int)$_POST['topicid'] : null;

        $theme = wp_get_theme();
        if (!is_user_logged_in() && ($theme->name == 'Municipio' || $theme->parent_theme == 'Municipio')) {
            $response = (isset($_POST['captcha']) && strlen($_POST['captcha']) > 0) ? $_POST['captcha'] : null;
            $reCaptcha = \Municipio\Helper\ReCaptcha::controlReCaptcha($response);

            if (!$reCaptcha) {
                echo 'false';
                wp_die();
            }
        }

        if ($answerId && $postId) {
            update_post_meta($answerId, 'customer_feedback_comment', $comment);
            update_post_meta($answerId, 'customer_feedback_comment_type', $commentType);
            update_post_meta($answerId, 'customer_feedback_email', $email);

            wp_update_post(array(
                'ID' => $answerId,
                'post_status' => 'pending'
            ));

            if ($topicId) {
                wp_set_post_terms($answerId, array($topicId), 'feedback_topic');
                \CustomerFeedback\Forwarding::maybeForward($answerId, $postId, $comment, $email, $topicId);
            }

            echo 'true';
        } else {
            echo 'false';
        }

        wp_die();
    }
}
