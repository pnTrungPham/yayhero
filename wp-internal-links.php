<?php

/**
 * Plugin Name:     WP - Internal Links
 * Plugin URI:      https://example.com
 * Description:     A simple plugin to manage internal links
 * Author:          Alan Project
 * Author URI:      https://example.com
 * Text Domain:     wpinternallinks
 * Domain Path:     /languages/i18n
 * Version:         1.0
 *
 * @package WPInternalLinks
 */

namespace WPInternalLinks;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'We\'re sorry, but you can not directly access this file.' );
}

define( 'WP_SOURCE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_SOURCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_SOURCE_IS_DEVELOPMENT', true );

//require_once WP_SOURCE_PLUGIN_PATH . 'vendor/autoload.php';

spl_autoload_register(
    function ( $class ) {
        $prefix   = __NAMESPACE__;
        $base_dir = __DIR__ . '/includes';

        $len = strlen( $prefix );
        if ( strncmp( $prefix, $class, $len ) !== 0 ) {
            return;
        }

        $relative_class_name = substr( $class, $len );

        $file = $base_dir . str_replace( '\\', '/', $relative_class_name ) . '.php';

        if ( file_exists( $file ) ) {
            require $file;
        }
    }
);

if ( ! wp_installing() ) {
    if ( ! function_exists( 'WPSource\\init' ) ) {
        function init() {
            \WPSource\Initialize::get_instance();
        }
    }
    add_action( 'plugins_loaded', 'WPSource\\init' );
}
