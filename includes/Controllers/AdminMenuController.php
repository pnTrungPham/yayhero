<?php
namespace WPInternalLinks\Controllers;

use WPInternalLinks\Utils\SingletonTrait;

/**
 * WPInternalLinks Plugin Initializer
 *
 * @method static AdminMenuController get_instance()
 */
class AdminMenuController {

    use SingletonTrait;

    protected function __construct() {
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
    }

    public function add_admin_menu() {
        add_menu_page(
            'wp-internal-links',
            __( 'Internal Link', 'wpinternallinks' ),
            'manage_options',
            'wp-internal-links',
            null,
            'dashicons-admin-links',
            10
        );

        add_submenu_page(
            'wp-internal-links',
            __( 'Dashboard', 'wpinternallinks' ),
            __( 'Dashboard', 'wpinternallinks' ),
            'manage_options',
            'wp_internal_links_dashboard',
            [ $this, 'menu_dashboard' ]
        );

        add_submenu_page(
            'wp-internal-links',
            __( 'Placement Assistant', 'wpinternallinks' ),
            __( 'Placement Assistant', 'wpinternallinks' ),
            'manage_options',
            'wp-internal-links-assistant',
            [ $this, 'menu_placement_assistant' ]
        );

        add_submenu_page(
            'wp-internal-links',
            __( 'Settings', 'wpinternallinks' ),
            __( 'Settings', 'wpinternallinks' ),
            'manage_options',
            'wp-internal-links-settings',
            [ $this, 'menu_settings' ]
        );

        add_submenu_page(
            'wp-internal-links',
            __( 'Go To Pro', 'wpinternallinks' ),
            __( 'Go To Pro', 'wpinternallinks' ),
            'manage_options',
            'wp-internal-links-go-to-pro',
            [ $this, 'menu_go_to_pro' ]
        );

        remove_submenu_page( 'wp-internal-links', 'wp-internal-links' );
    }

    public static function menu_dashboard() {
        $path = WP_INTERNAL_LINKS_PLUGIN_PATH . 'templates/dashboard/dashboard.php';
        if ( file_exists( $path ) ) {
            require $path;
        }
    }

    public static function menu_placement_assistant() {
        $path = WP_INTERNAL_LINKS_PLUGIN_PATH . 'templates/placement-assistant/placement-assistant.php';
        if ( file_exists( $path ) ) {
            require $path;
        }
    }

    public static function menu_settings() {
        $path = WP_INTERNAL_LINKS_PLUGIN_PATH . 'templates/settings/settings.php';
        if ( file_exists( $path ) ) {
            require $path;
        }
    }

    public static function menu_go_to_pro() {
        $path = WP_INTERNAL_LINKS_PLUGIN_PATH . 'templates/go-pro/go-pro.php';
        if ( file_exists( $path ) ) {
            require $path;
        }
    }
}
