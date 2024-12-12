<?php

/**
 * Plugin Name: Rapid File Manager
 * Description: Rapid File Manager is a plugin that allows you to manage your files in the admin website dashboard.
 * Author: Rapid File Manager
 * Text Domain: rpfm
 * Domain Path: /i18n/languages/
 * Version: 1.0.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * @package RPFM
 */

namespace RPFM;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'We\'re sorry, but you can not directly access this file.' );
}

if ( file_exists( __DIR__ . '/includes/ElFinder/php/autoload.php' ) ) {
    require_once __DIR__ . '/includes/ElFinder/php/autoload.php';
}

define( 'RPFM_VERSION', '1.0' );

define( 'RPFM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'RPFM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RPFM_IS_DEVELOPMENT', true );


if ( ! defined( 'RPFM_REST_NAMESPACE' ) ) {
    define( 'RPFM_REST_NAMESPACE', 'wp_source/v1' );
}

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
    if ( ! function_exists( 'RPFM\\init' ) ) {
        function init() {
            \RPFM\Initialize::get_instance();
        }
    }
    add_action( 'plugins_loaded', 'RPFM\\init' );
}
