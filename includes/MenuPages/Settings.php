<?php

namespace WPSource\MenuPages;

use WPSource\Utils\SingletonTrait;

defined( 'ABSPATH' ) || exit;

/**
 * Settings Classes
 */
class Settings {
    use SingletonTrait;

    protected function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'admin_menu', [ $this, 'wpsource_add_admin_page' ] );
    }

    public function wpsource_add_admin_page() {
        add_menu_page(
            __( 'WP Source', 'wpsource' ),
            __( 'WP Source', 'wpsource' ),
            'manage_options',
            'wpsource/wpsource-admin.php',
            [ $this, 'wpsource_render_admin_page' ],
            'dashicons-shield',
            30
        );

    }

    public function wpsource_render_admin_page() {
        include WP_SOURCE_PLUGIN_PATH . 'views/Template/Page/wpsource-admin.php';
    }

}
