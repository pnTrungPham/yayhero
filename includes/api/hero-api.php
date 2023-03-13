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

function yayhero_get_heroes()
{
    $posts = get_posts(['post_type' => POST_TYPE]);

    if (empty($posts)) {
        return null;
    }

    return array_map(function ($post) {

        $extra_fields_object = json_decode($post->post_content);
        return [
            'id' => $post->ID,
            'name' => $post->post_title,
            'modified' => $post->post_modified,

            'class' => $extra_fields_object->class,
            'level' => $extra_fields_object->level,
            'attributes' => $extra_fields_object->attributes,
        ];
    }, $posts);
}

function yayhero_get_hero_by_id()
{
    return 'one';
}

function yayhero_post_hero(WP_REST_Request $request)
{
    $payload = $request->get_json_params();

    $payload_clone = $payload;

    unset($payload_clone['name']);

    $post_content = json_decode(json_encode($payload_clone), FALSE);

    $post = [
        'post_title' => $payload['name'],
        'post_content' => json_encode($post_content),
        'post_type' => POST_TYPE,
        'post_status' => 'publish',

    ];

    $result = wp_insert_post($post, true);

    return $result;
}

function yayhero_patch_hero()
{
    return 'edited';
}

function yayhero_delete_hero()
{
    return 'deleted';
}
