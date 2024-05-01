<?php

namespace WPSource\Controllers;

use WPSource\Abstracts\BaseController;
use WPSource\Utils\SingletonTrait;
use WPSource\Models\SettingModel;


/**
 * Setting Controller
 *
 * @method static SettingController get_instance()
 */
class SettingController extends BaseController {
    use SingletonTrait;

    private $model = null;

    protected function __construct() {
        $this->model = SettingModel::get_instance();
        $this->init_hooks();
    }

    protected function init_hooks() {
        register_rest_route(
            WP_SOURCE_FM_REST_NAMESPACE,
            '/settings',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'exec_get_settings' ],
                    'permission_callback' => [ $this, 'permission_callback' ],
                ],
                [
                    'methods'             => 'PATCH',
                    'callback'            => [ $this, 'exec_update_settings' ],
                    'permission_callback' => [ $this, 'permission_callback' ],
                ],
            ]
        );

    }

    public function exec_get_settings( \WP_REST_Request $request ) {
        return $this->exec( [ $this, 'get_settings' ], $request );
    }


    public function get_settings() {
        $settings = $this->model::find_all();
        return $settings;
    }

    public function exec_update_settings( \WP_REST_Request $request ) {
        return $this->exec( [ $this, 'update_settings' ], $request );
    }

    public function update_settings( \WP_REST_Request $request ) {
        $settings = is_array( $request->get_param( 'settings' ) ) ? array_map( 'sanitize_text_field', wp_unslash( $request->get_param( 'settings' ) ) ) : [];
        $this->model::update( $settings );
        return [ 'success' => true ];
    }

}
