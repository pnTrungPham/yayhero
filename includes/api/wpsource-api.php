<?php

function yayhero_api() {
    register_rest_route('yayhero/v1', '/heroes', [
        [
            'methods' => 'GET',
            'callback' => 'yayhero_get_heroes',
            'permission_callback' => '__return_true',
        ],
        [
            'methods' => 'POST',
            'callback' => 'yayhero_post_hero',
            'permission_callback' => '__return_true'
        ]
    ]);

    $yayhero_hero_id_api_args = array(
        'hero_id' => array(
            'validate_callback' => function ($param, $request, $key) {
                return is_numeric($param);
            }
        ),
    );

    register_rest_route(
        'yayhero/v1',
        '/heroes/(?P<hero_id>\d+)',
        [
            [
                'methods' => 'PATCH',
                'callback' => 'yayhero_patch_hero',
                'args' => $yayhero_hero_id_api_args,
                'permission_callback' => '__return_true'
            ],
            [
                'methods' => 'DELETE',
                'callback' => 'yayhero_delete_hero',
                'args' => $yayhero_hero_id_api_args,
                'permission_callback' => '__return_true'
            ]
        ]
    );
}

function get_hero_from_post(WP_Post $post) {
    $extra_fields_object = json_decode($post->post_content);
    return [
        'id' => $post->ID,
        'username' => $extra_fields_object->username,
        'age' => $extra_fields_object->age
    ];
}

function yayhero_get_heroes() {
    $posts = get_posts([
        'post_type' => POST_TYPE,
        'posts_per_page' => -1, 
    ]);

    if (empty($posts)) {
        $content = [];
    } else {
        $content = array_map(function ($post) {
            return get_hero_from_post($post);
        }, $posts);
    }

    return array(
        'data' => $content
    );
 
}

function get_post_from_hero($payload) {
    $payload_clone = $payload;

    $post_content = json_decode(json_encode($payload_clone), FALSE);

    $post = [
        'post_title' => $post_content->data->username,
        'post_content' => json_encode($post_content),
        'post_type' => POST_TYPE,
        'post_status' => 'publish',
    ];

    return $post;
}

function yayhero_post_hero(WP_REST_Request $request) {
    $payload = $request->get_json_params();

    $post = get_post_from_hero($payload);

    $result = wp_insert_post($post, true);

    return $result;
}

function yayhero_delete_hero(WP_REST_Request $request) {

    $hero_id = $request->get_url_params()['hero_id'];

    if (!$hero_id) {

        return new WP_Error('no_id', 'Please provide hero ID', ['status' => 404]);
    }

    $result = wp_delete_post($hero_id);

    return $result;
}

function yayhero_patch_hero(WP_REST_Request $request) {
    $hero_id = $request->get_url_params()['hero_id'];

    if (!$hero_id) {
        return new WP_Error('no_id', 'Please provide hero ID', ['status' => 404]);
    }

    $payload = $request->get_json_params();

    $post = get_post_from_hero($payload);

    $post['ID'] = $hero_id;

    $result = wp_update_post($post, true);

    return $result;
}

add_action('rest_api_init', 'yayhero_api');