<?php

define('POST_TYPE', 'yayhero');

define('DEFAULT_PAGE_SIZE', 5);


function yayhero_has_api_write_permission()
{
    return current_user_can('manage_options');
}

function yayhero_has_api_read_permission()
{
    return current_user_can('read');
}


add_action('rest_api_init', function () {
    register_rest_route('yayhero/v1', '/heroes', [
        [
            'methods' => 'GET',
            'callback' => 'yayhero_get_heroes_with_pagination',
            'permission_callback' => 'yayhero_has_api_read_permission',
            'args' => [
                'page' => [
                    'required' => true,
                    'default' => 1,
                    'sanitize_callback' => 'sanitize_text_field',
                ],
                'size' => [
                    'required' => true,
                    'default' => DEFAULT_PAGE_SIZE,
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ]
        ],
        [
            'methods' => 'POST',
            'callback' => 'yayhero_post_hero',
            'permission_callback' => 'yayhero_has_api_write_permission'
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
                'permission_callback' => 'yayhero_has_api_read_permission'
            ],
            [
                'methods' => 'PATCH',
                'callback' => 'yayhero_patch_hero',
                'args' => $yayhero_hero_id_api_args,
                'permission_callback' => 'yayhero_has_api_write_permission'
            ],
            [
                'methods' => 'DELETE',
                'callback' => 'yayhero_delete_hero',
                'args' => $yayhero_hero_id_api_args,
                'permission_callback' => 'yayhero_has_api_write_permission'
            ],
            [
                'methods' => 'PUT',
                'callback' => 'yay_hero_level_up_hero',
                'args' => $yayhero_hero_id_api_args,
                'permission_callback' => 'yayhero_has_api_write_permission'
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
    unset($payload_clone['id']);
    unset($payload_clone['modified']);

    $post_content = json_decode(json_encode($payload_clone), FALSE);

    $post = [
        'post_title' => $payload['name'],
        'post_content' => json_encode($post_content),
        'post_type' => POST_TYPE,
        'post_status' => 'publish',
    ];

    return $post;
}

function yayhero_get_heroes($page = 1, $size)
{
    $offset = ($page - 1) * $size;

    $posts = get_posts([
        'post_type' => POST_TYPE,
        'numberposts' => $size,
        'offset' => $offset
    ]);

    if (empty($posts)) {
        $content = [];
    } else {
        $content = array_map(function ($post) {
            return get_hero_from_post($post);
        }, $posts);
    }

    $post_counts = wp_count_posts('yayhero')->publish;

    return [
        'content' => $content,
        'page' => $page,
        'size' => $size,
        'totalItems' => $post_counts,
    ];
}

function yayhero_get_heroes_with_pagination(WP_REST_Request $request)
{
    $page = $request->get_params()['page'];

    $size = $request->get_params()['size'];

    $result = yayhero_get_heroes($page, $size);

    return $result;
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

function yay_hero_level_up_hero(WP_REST_Request $request)
{
    $hero_id = $request->get_url_params()['hero_id'];

    if ($hero_id) {

        $post = get_post($hero_id);

        $hero = get_hero_from_post($post);

        level_up($hero);

        $hero['level'] = $hero['level'] + 1;


        $post = get_post_from_hero($hero);

        $post['ID'] = $hero_id;

        $result = wp_update_post($post, true);

        return $result;
    }

    return new WP_Error('no_id', 'Hero does not exist', ['status' => 404]);
}

function level_up($hero)
{
    $hero_class = $hero['class'];

    switch ($hero_class) {
        case 'Warrior':
            $hero['attributes']->strength += 8;
            $hero['attributes']->vitality += 5;
            $hero['attributes']->dexterity += 2;
            $hero['attributes']->intelligence += 1;
            break;

        case 'Paladin':
            $hero['attributes']->strength += 6;
            $hero['attributes']->vitality += 6;
            $hero['attributes']->dexterity += 3;
            $hero['attributes']->intelligence += 3;
            break;

        case 'Mage':
            $hero['attributes']->strength += 3;
            $hero['attributes']->vitality += 3;
            $hero['attributes']->dexterity += 2;
            $hero['attributes']->intelligence += 10;
            break;

        case 'Rogue':
            $hero['attributes']->strength += 4;
            $hero['attributes']->vitality += 4;
            $hero['attributes']->dexterity += 8;
            $hero['attributes']->intelligence += 4;
            break;

        case 'Shaman':
            $hero['attributes']->strength += 3;
            $hero['attributes']->vitality += 3;
            $hero['attributes']->dexterity += 6;
            $hero['attributes']->intelligence += 7;
            break;

        default:
            break;
    }
}
