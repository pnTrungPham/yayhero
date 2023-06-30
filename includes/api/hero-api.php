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
        'post_title' => $payload['name'],
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

add_action('rest_api_init', 'yayhero_api');