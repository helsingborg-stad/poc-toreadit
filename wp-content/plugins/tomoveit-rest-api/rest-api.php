<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Silence is golden.' );
}

class TomoveitRestApi_Routes {

    public function register_routes()
    {
        $version = '1';
        $namespace = 'TomoveitRestApi/v' . $version;

        register_rest_route($namespace, '/getTexts', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'rest_get_texts'],
            ],
        ]);
        register_rest_route($namespace, '/data', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_get_data'],
                'args' => [
                    'pin' => [
                        'required' => true,
                        'validate_callback' => function($param, $request, $key) {
                            if(!is_string($param)) return false;
                            return $request;
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/login', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_login'],
                'args' => [
                    'pin' => [
                        'required' => true,
                        'validate_callback' => function($param, $request, $key) {
                            if(!is_string($param)) return false;
                            return $request;
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/activities', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_get_activities'],
                'args' => [
                    'pin' => [
                        'required' => true,
                        'validate_callback' => function($param, $request, $key) {
                            if(!is_string($param)) return false;
                            return $request;
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/companyActivities', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'rest_get_company_activities'],
            ],
        ]);
        register_rest_route($namespace, '/setActivity', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_set_activity'],
            ],
            'args' => [
                'pin' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        if(!is_string($param)) return false;
                        return $request;
                    },
                ],
                'selectedPostId' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        if(!is_string($param)) return false;
                        return $request;
                    },
                ],
            ],
        ]);
        register_rest_route($namespace, '/resetActivity', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_reset_activity'],
            ],
            'args' => [
                'pin' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        if(!is_string($param)) return false;
                        return $request;
                    },
                ],
            ],
        ]);
        register_rest_route($namespace, '/randomize', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'rest_randomize_post'],
            ],
        ]);
        register_rest_route($namespace, '/getRunningActivity', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_running_activity'],
                'args' => [
                    'pin' => [
                        'required' => true,
                        'validate_callback' => function($param, $request, $key) {
                            if(!is_string($param)) return false;
                            return $request;
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/setDoneActivity', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_set_done_activity'],
                'postId' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        if(!is_string($param)) return false;
                        return $request;
                    },
                ],
                'pin' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        if(!is_string($param)) return false;
                        return $request;
                    },
                ],
            ],
        ]);
        register_rest_route($namespace, '/reading', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_add_pages'],
                'pin' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        if(!is_string($param)) return false;
                        return $request;
                    },
                ],
                'pages' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        if(!is_int($param)) return false;
                        return $request;
                    },
                ],
            ],
        ]);
        register_rest_route($namespace, '/reading-check', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_check_if_already_registered'],
                'pin' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        if(!is_string($param)) return false;
                        return $request;
                    },
                ],
            ],
        ]);
        register_rest_route($namespace, '/classes-data', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'rest_get_total_classes_data'],
            ],
        ]);
    }

    public function rest_get_texts() {
        $postId = '';

        $post = get_posts([
            'numberposts' => 1,
            'post_type' => 'texts',
            'orderby' => 'ASC',
        ]);

        foreach ($post as $item) {
            $postId = $item->ID;
        }

        $text1 = get_field('texts_login_text', $postId);
        $text2 = get_field('texts_welcome_1', $postId);
        $text3 = get_field('texts_welcome_2', $postId);
        $text4 = get_field('texts_welcome_blue', $postId);
        $text5 = get_field('texts_welcome_3', $postId);
        $text6 = get_field('texts_introduction_1', $postId);
        $text7 = get_field('texts_introduction_2', $postId);
        $text8 = get_field('texts_introduction_3', $postId);
        $text9 = get_field('texts_activities_1', $postId);
        $text10 = get_field('texts_activities_2', $postId);
        $text11 = get_field('texts_activities_3', $postId);
        $text12 = get_field('texts_activities_done_1', $postId);
        $text13 = get_field('texts_activities_done_2', $postId);
        $text14 = get_field('texts_celebrate_1', $postId);
        $text15 = get_field('texts_celebrate_2', $postId);
        $text16 = get_field('texts_activities_bottom_text', $postId);
        $text17 = get_field('texts_activity_chosen_1', $postId);
        $text18 = get_field('texts_activity_chosen_2', $postId);

        $result = array(
            "textLogin" => $text1,
            "textWelcome1" => $text2,
            "textWelcome2" => $text3,
            "textWelcomeBlue" => $text4,
            "textWelcome3" => $text5,
            "textIntroduction1" => $text6,
            "textIntroduction2" => $text7,
            "textIntroduction3" => $text8,
            "textsActivities1" => $text9,
            "textsActivities2" => $text10,
            "textsActivities3" => $text11,
            "textsActivitiesDone1" => $text12,
            "textsActivitiesDone2" => $text13,
            "textsCelebrate1" => $text14,
            "textsCelebrate2" => $text15,
            "textsActivitiesBottom" => $text16,
            "textsActivityChosen1" => $text17,
            "textsActivityChosen2" => $text18,
        );

        return $result;
    }

    public function rest_login($request) {
        $pin = $request->get_param('pin');

        global $wpdb;
        $table = 'toreadit_activity';

        if($this->check_pin($pin)) return ([
           'error' => 'Fel pinkod'
        ]);

        $queryCheck = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE pin = '%s';", $pin));

        if (count($queryCheck) == 0) {
            $wpdb->insert($table, array(
                'pin' => $pin,
                'selected_activity' => '',
                'used_activities' => '',
                'first_time' => 1,
            ));
        }

        $admin = $this->find_if_admin($pin);
        return ['admin' => $admin];
    }

    public function rest_get_activities($request) {
        $pin = $request->get_param('pin');
        $result = [];
        global $wpdb;

        $table_daily = 'toreadit_daily_posts';
        $table_activity = 'toreadit_activity';

        $query = $wpdb->prepare("SELECT post1, post2, post3 FROM $table_daily WHERE id = 1;");
        $query_result = $wpdb->get_row($query, ARRAY_A);

        $query = $wpdb->prepare("SELECT used_activities FROM $table_activity WHERE pin = '%s';", $pin);
        $query_result_used = $wpdb->get_row($query);

        foreach ($query_result as $id) {
            if (!preg_match("~\b$id\b~", $query_result_used->used_activities)) {
                $postId = $id;
                $title = get_the_title($id);
                $time = get_field('activity_time', $id);
                $image = get_field('activity_image', $id);
                $group = get_field('activity_group', $id);
                $description = get_field('activity_description', $id);
                $needed = get_field('activity_whats_needed', $id);
                $numbers = get_field('activity_numbers', $id);
                $instruction = get_field('activity_instruktioner', $id);
                $videoUrl = get_field('activity_youtube_link', $id);
                $author = get_field('activity_author', $id);
                $videoText = get_field('activity_video_text', $id);

                array_push($result, (object)[
                    'title' => html_entity_decode($title),
                    'time' => $time,
                    'image' => $image,
                    'group' => $group,
                    'description' => $description,
                    'needed' => $needed,
                    'numbers' => $numbers,
                    'instruction' => $instruction,
                    'videoUrl' => $videoUrl,
                    'author' => $author,
                    'postId' => $postId,
                    'videoText' => $videoText,
                ]);
            }
        }

        return $result;
    }

    public function rest_get_company_activities() {
        $activities = [];

        $posts = get_posts([
            'numberposts' => -1,
            'post_type' => 'review_visitor',
        ]);

        foreach ($posts as $post) {
            $review = get_field('review_visit_check');
            if ($review) {
                array_push($activities, (object) [
                    'book' => get_field('review_visit_book', $post->ID),
                    'stars' => get_field('review_visit_stars', $post->ID),
                    'best' => get_field('review_visit_best', $post->ID),
                ]);
            } else {
                array_push($activities, (object) [
                    'what_did_they_read' => get_field('review_visit_what_did_they_read', $post->ID),
                    'meaning' => get_field('review_visit_meaning', $post->ID),
                    'favorite' => get_field('review_visit_favorit', $post->ID),
                    'why_reading' => get_field('review_visit_why_reading', $post->ID),
                ]);
            }

            array_push($activities, (object)[
                'title' => html_entity_decode(get_the_title($post->ID)),
                'id' => $post->ID,
                'short_text' => get_field('review_visit_text', $post->ID),
                'name' => get_field('review_visit_name', $post->ID),
                'image' => get_field('review_visit_image', $post->ID),
                'author' => get_field('review_visit_author', $post->ID),
                'video_url' => get_field('review_visit_video_url', $post->ID),
            ]);
        }

        return $activities;
    }

    public function rest_set_activity($request){
        global $wpdb;
        $pin = $request->get_param('pin');

        $post = $request->get_param('selectedPostId');

        if($this->check_if_not_valid_post($post)) return false;

        $table = 'toreadit_activity';
        $data = array('selected_activity'=> $post);
        $where = array('pin' => $pin);
        $wpdb->update( $table, $data, $where);

        $get_selected_post_data = $this->prepare_post_data($post);

        return $get_selected_post_data;
    }

    public function check_if_not_valid_post($postId){
        global $wpdb;

        $table_daily = 'toreadit_daily_posts';

        $query = $wpdb->prepare("SELECT post1, post2, post3 FROM $table_daily WHERE id = 1");
        $query_result = $wpdb->get_row($query, ARRAY_A);

        foreach ($query_result as $id) {
            if ($id == $postId) return false;
        }
        return true;
    }

    public function rest_reset_activity($request){
        global $wpdb;
        $pin = $request->get_param('pin');

        $table = 'toreadit_activity';
        $data = array('selected_activity'=> '');
        $where = array('pin' => $pin);
        $wpdb->update( $table, $data, $where);

        return 200;
    }

    public function rest_running_activity($request) {
        global $wpdb;
        $table = 'toreadit_activity';
        $pin = $request->get_param('pin');

        $query = $wpdb->get_results("SELECT selected_activity FROM $table WHERE pin='$pin'");

        $post_id = NULL;
        foreach($query as $item) {
            $post_id = $item->selected_activity;
        }

        if(!$post_id) return false;

        return $this->prepare_post_data($post_id);
    }

    public function rest_randomize_post() {
        $postIds = array();
        global $wpdb;

        $postsGroup = get_posts([
            'numberposts' => 2,
            'post_type' => 'activities',
            'orderby' => 'rand',
            'meta_query' => array(
            array(
                'key'     => 'activity_group',
                'value'   => 1,
                )
            )
        ]);

        $postsSingle = get_posts([
            'numberposts' => 1,
            'post_type' => 'activities',
            'orderby' => 'rand',
            'meta_query' => array(
                array(
                    'key'     => 'activity_group',
                    'value'   => 0,
                )
            )
        ]);

        foreach ($postsGroup as $item) {
            $postId = $item->ID;
            array_push($postIds, $postId );
        }

        foreach ($postsSingle as $item) {
            $postId = $item->ID;
            array_push($postIds, $postId );
        }

        $table = 'toreadit_daily_posts';
        $data = array(
            'post1'=> $postIds[0],
            'post2'=> $postIds[1],
            'post3'=> $postIds[2],
        );
        $where = array('id' => 1);
        $wpdb->update( $table, $data, $where);

        $table = 'toreadit_activity';
        $wpdb->query($wpdb->prepare("UPDATE $table SET selected_activity='', used_activities=''"));
    }

    public function rest_set_done_activity($request) {
        global $wpdb;
        $pin = $request->get_param('pin');
        $post_id = $request->get_param('postId');

        $table = 'toreadit_activity';

        //$wpdb->query($wpdb->prepare("UPDATE $table SET used_activities = CONCAT(used_activities,'".",".$post_id."') WHERE mac = '$mac'"));
        $wpdb->query($wpdb->prepare("UPDATE $table SET used_activities = CONCAT(used_activities, ' ', $post_id) WHERE pin = '$pin'"));
        $wpdb->query($wpdb->prepare("UPDATE $table SET selected_activity = '' WHERE pin = '$pin'"));
    }

    public function prepare_post_data($post_id) {
            $result = array();

            $postId = $post_id;
            $title = get_the_title($post_id);
            $time = get_field('activity_time', $post_id);
            $image = get_field('activity_image', $post_id);
            $group = get_field('activity_group', $post_id);
            $description = get_field('activity_description', $post_id);
            $needed = get_field('activity_whats_needed', $post_id);
            $numbers = get_field('activity_numbers', $post_id);
            $instruction = get_field('activity_instruktioner', $post_id);
            $videoUrl = get_field('activity_youtube_link', $post_id);
            $author = get_field('activity_author',  $post_id);
            $videoText = get_field('activity_video_text', $post_id);

            array_push($result, (object)[
                'title' => html_entity_decode($title),
                'time' => $time,
                'image' => $image,
                'group' => $group,
                'description' => $description,
                'needed' => $needed,
                'numbers' => $numbers,
                'instruction' => $instruction,
                'postId' => $postId,
                'videoUrl' => $videoUrl,
                'author' => $author,
                'videoText' => $videoText,
            ]);

        return $result;
    }

    public function check_pin($pin) {
        $args = array(
            'numberposts'	=> 1,
            'post_type'		=> 'students',
            'meta_key'		=> 'students_pin_code',
            'meta_value'	=> $pin
        );

        $the_query = new WP_Query( $args );
        return empty($the_query->posts);
    }

    public function find_if_admin($pin) {
        $args = array(
            'numberposts'	=> 1,
            'post_type'		=> 'students',
            'meta_key'		=> 'students_pin_code',
            'meta_value'	=> $pin
        );

        $the_query = new WP_Query( $args );

        if(empty($the_query->posts)) {
            return false;
        } else {
            $admin = get_field('students_admin', $the_query->posts[0]->ID);

            return $admin;
        }
    }

    public function rest_add_pages($request) {
        $pin = $request->get_param('pin');
        $pages = $request->get_param('pages');
        $date = date('Y-m-d');
        $class = $this->get_student_class($pin);

        $table = 'toreadit_reading';

        global $wpdb;
        $wpdb->insert($table, array(
            'pages' => $pages,
            'pin' => $pin,
            'class' => $class,
            'created_at' => $date,
        ));
    }

    public function get_student_class($pin) {
        $posts = get_posts(array(
            'numberposts'	=> -1,
            'post_type'		=> 'students',
            'meta_key'		=> 'students_pin_code',
            'meta_value'	=> $pin,
        ));
        $class = get_field('students_class', $posts[0]->ID);
        return $class;
    }

    public function rest_check_if_already_registered($request) {
        $pin = $request->get_param('pin');

        global $wpdb;
        $table = 'toreadit_reading';
        $date = date('Y-m-d');
        $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE pin='%s' AND created_at='%s';", $pin, $date));
        return count($result) > 0;
    }

    public function rest_get_data($request) {
        $pin = $request->get_param('pin');
        $startDate = $request->get_param('start_date');
        $endDate = $request->get_param('end_date');
        global $wpdb;
        $table = 'toreadit_reading';
        $results = $wpdb->get_results($wpdb->prepare("SELECT pages, created_at FROM $table WHERE pin='%s' AND created_at <= '%s' AND created_at >= '%s';", $pin, $endDate, $startDate));

        $data = [];
        $total_pages_sum = 0;
        // TODO: Refactor this horrible for loop
        for ($i = 1;$i < 8;$i++) {
            $date = date('Y-m-d', strtotime($startDate. ' + ' . $i .' days'));
            $pages = 0;
            foreach($results as $result) {
                if ($result->created_at === $date) {
                   $pages = $result->pages;
                    $total_pages_sum += $result->pages;
                }
            }
            array_push($data, $pages);
        }

        return ['pages_array' => $data, 'total_pages_sum' => $total_pages_sum];
    }

    public function rest_get_total_classes_data($request) {
        $startDate = $request->get_param('start_date');
        $endDate = $request->get_param('end_date');
        $table = 'toreadit_reading';
        global $wpdb;

        $results_6a = $wpdb->get_results($wpdb->prepare("SELECT created_at, sum(pages) as sum_pages FROM $table WHERE class='6A' AND created_at <= '%s' AND created_at >= '%s' group by created_at;", $endDate, $startDate));
        $results_6b = $wpdb->get_results($wpdb->prepare("SELECT created_at, sum(pages) as sum_pages FROM $table WHERE class='6B' AND created_at <= '%s' AND created_at >= '%s' group by created_at;", $endDate, $startDate));
        $results_6c = $wpdb->get_results($wpdb->prepare("SELECT created_at, sum(pages) as sum_pages FROM $table WHERE class='6C' AND created_at <= '%s' AND created_at >= '%s' group by created_at;", $endDate, $startDate));

        $data = [];
        array_push($data, ['class' => '6A' , 'data' => $this->format_class_data($results_6a, $startDate), 'goal' => 1000]);
        array_push($data, ['class' => '6B' , 'data' => $this->format_class_data($results_6b, $startDate), 'goal' => 1000]);
        array_push($data, ['class' => '6C' , 'data' => $this->format_class_data($results_6c, $startDate), 'goal' => 1000]);
        return $data;
    }

    public function format_class_data($results, $start_date) {
        $data = [];
        $total_pages_sum = 0;
        // TODO: Refactor this horrible for loop
        for ($i = 1;$i < 8;$i++) {
            $date = date('Y-m-d', strtotime($start_date. ' + ' . $i .' days'));
            $pages = 0;
            foreach($results as $result) {
                if ($result->created_at === $date) {
                    $pages = $result->sum_pages;
                    $total_pages_sum += $result->sum_pages;
                }
            }
            array_push($data, $pages);
        }
        return ['pages_array' => $data, 'total_pages_sum' => $total_pages_sum];
    }
}
