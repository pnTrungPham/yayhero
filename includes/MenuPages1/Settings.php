<?php

namespace WPSource\MenuPages;

defined( 'ABSPATH' ) || exit;

class Settings {

    protected static $instance = null;

    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self();
            self::$instance->do_hooks();
        }

        return self::$instance;
    }

    private function do_hooks() {
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
        include WP_SOURCE_PLUGIN_PATH . 'templates/Pages/wpsource-admin.php';
    }

}
