<?php

define('POST_TYPE', 'yayhero');
function yayhero_has_api_permission()
{
    return current_user_can('manage_options');
}

add_action('rest_api_init', function () {
    register_rest_route('yayhero/v1', '/heroes', [
        [
            'methods' => 'GET',
            'callback' => 'yayhero_get_heroes',
            'permission_callback' => 'yayhero_has_api_permission'
        ],
        [
            'methods' => 'POST',
            'callback' => 'yayhero_post_hero',
            'permission_callback' => 'yayhero_has_api_permission'
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
                'methods' => 'GET',
                'callback' => 'yayhero_get_hero_by_id',
                'args' => $yayhero_hero_id_api_args,
                'permission_callback' => 'yayhero_has_api_permission'
            ],
            [
                'methods' => 'PATCH',
                'callback' => 'yayhero_patch_hero',
                'args' => $yayhero_hero_id_api_args,
                'permission_callback' => 'yayhero_has_api_permission'
            ],
            [
                'methods' => 'DELETE',
                'callback' => 'yayhero_delete_hero',
                'args' => $yayhero_hero_id_api_args,
                'permission_callback' => 'yayhero_has_api_permission'
            ]
        ]
    );
});

function get_hero_from_post(WP_Post $post)
{
    $extra_fields_object = json_decode($post->post_content);
    return [
        'id' => $post->ID,
        'name' => $post->post_title,
        'modified' => $post->post_modified,
        'class' => $extra_fields_object->class,
        'level' => $extra_fields_object->level,
        'attributes' => $extra_fields_object->attributes,
    ];
}

function get_post_from_hero($payload)
{

    $payload_clone = $payload;

    unset($payload_clone['name']);

    $post_content = json_decode(json_encode($payload_clone), FALSE);

    $post = [
        'post_title' => $payload['name'],
        'post_content' => json_encode($post_content),
        'post_type' => POST_TYPE,
        'post_status' => 'publish',
    ];

    return $post;
}

function yayhero_get_heroes()
{
    $posts = get_posts(['post_type' => POST_TYPE, 'numberposts' => -1]);

    if (empty($posts)) {
        return [];
    }

    return array_map(function ($post) {

        return get_hero_from_post($post);
    }, $posts);
}

function yayhero_get_hero_by_id(WP_REST_Request $request)
{
    $hero_id = $request->get_url_params()['hero_id'];

    if ($hero_id) {

        $post = get_post($hero_id);
        return get_hero_from_post($post);
    }

    return new WP_Error('no_id', 'Please provide hero ID', ['status' => 404]);
}

function yayhero_post_hero(WP_REST_Request $request)
{
    $payload = $request->get_json_params();

    $post = get_post_from_hero($payload);

    $result = wp_insert_post($post, true);

    return $result;
}

function yayhero_patch_hero(WP_REST_Request $request)
{
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

function yayhero_delete_hero(WP_REST_Request $request)
{

    $hero_id = $request->get_url_params()['hero_id'];

    if (!$hero_id) {

        return new WP_Error('no_id', 'Please provide hero ID', ['status' => 404]);
    }

    $result = wp_delete_post($hero_id);

    return $result;
}
