<?php

/**
 * Plugin Name:     File Manager Plus - WPSource
 * Plugin URI:      https://wpsource.tech/
 * Description:     Starter plugin.Basic WordPress plugin development.
 * Author:          Alan Project
 * Author URI:      https://wpsource.tech/
 * Text Domain:     wpsource
 * Domain Path:     /languages
 * Version:         1.0
 *
 * @package WPSource
 */

namespace WPSource;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'We\'re sorry, but you can not directly access this file.' );
}

if ( file_exists( dirname( __FILE__ ) . '/includes/ElFinder/php/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/includes/ElFinder/php/autoload.php';
}

define( 'WP_SOURCE_FM_VERSION', '1.7.8' );

define( 'WP_SOURCE_FM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_SOURCE_FM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_SOURCE_FM_IS_DEVELOPMENT', true );

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
