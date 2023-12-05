<?php

/**
 * Plugin Name:     WPSource - Alan Project
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

define( 'WP_SOURCE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_SOURCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_SOURCE_IS_DEVELOPMENT', true );

require_once WP_SOURCE_PLUGIN_PATH . 'vendor/autoload.php';

if ( ! wp_installing() ) {
    if ( ! function_exists( 'WPSource\\init' ) ) {
        function init() {
            // include WP_SOURCE_PLUGIN_PATH . 'includes/Pages/wpsource-admin.php';
            // include WP_SOURCE_PLUGIN_PATH . 'includes/Enqueue/wpsource-app.php';
            // include WP_SOURCE_PLUGIN_PATH . 'includes/API/wpsource-api.php';

            //\WPSource\MenuPages\Settings::get_instance();
        }
    }
    add_action( 'plugins_loaded', 'WPSource\\init' );
}
