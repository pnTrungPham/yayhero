<?php

namespace WPSource\Controllers;

use WPSource\Abstracts\BaseController;
use WPSource\Utils\SingletonTrait;
use WPSource\Models\SettingModel;


/**
 * User Role Controller
 *
 * @method static UserRoleController get_instance()
 */
class UserRoleController extends BaseController {
    use SingletonTrait;

    private $model = null;

    protected function __construct() {
        $this->model = SettingModel::get_instance();
        $this->init_hooks();

    }

    protected function init_hooks() {
        register_rest_route(
            RPFM_REST_NAMESPACE,
            '/user-role',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'exec_get_user_role_settings' ],
                    'permission_callback' => [ $this, 'permission_callback' ],
                ],
                [
                    'methods'             => 'PATCH',
                    'callback'            => [ $this, 'exec_update_user_role_settings' ],
                    'permission_callback' => [ $this, 'permission_callback' ],
                ],
            ]
        );

    }

    public function exec_get_user_role_settings( \WP_REST_Request $request ) {
        return $this->exec( [ $this, 'get_user_role_settings' ], $request );
    }


    public function get_user_role_settings() {
        $settings = $this->model::find_all();
        return $settings;
    }

    public function exec_update_user_role_settings( \WP_REST_Request $request ) {
        return $this->exec( [ $this, 'update_user_role_settings' ], $request );
    }

    public function update_user_role_settings( \WP_REST_Request $request ) {
        $settings = is_array( $request->get_param( 'settings' ) ) ? array_map( 'sanitize_text_field', wp_unslash( $request->get_param( 'settings' ) ) ) : [];
        $this->model::update( $settings );
        return [ 'success' => true ];
    }

}
