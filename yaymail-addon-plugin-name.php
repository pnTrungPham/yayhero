<?php
/**
 * Plugin Name: Cute plugin
 * Plugin URI: https://yaycommerce.com/yaymail-woocommerce-email-customizer/
 * Description: Customize [Plugin Name] email templates with YayMail - WooCommerce Email Customizer
 * Version: 1.0
 * Author: YayCommerce
 * Author URI: https://yaycommerce.com
 * Text Domain: yaymail
 * WC requires at least: 3.0.0
 * WC tested up to: 7.3.0
 * Domain Path: /i18n/languages/
 *
 * @package YayMailAddon
 */

namespace YayMailAddon;

defined( 'ABSPATH' ) || exit;


if ( ! defined( 'YAYMAIL_ADDON_PLUGIN_NAME_NAME' ) ) {
	define( 'YAYMAIL_ADDON_PLUGIN_NAME_NAME', 'WooCommerce Subscriptions' );
}

if ( ! defined( 'YAYMAIL_ADDON_PLUGIN_NAME_LINK_URL' ) ) {
	define( 'YAYMAIL_ADDON_PLUGIN_NAME_LINK_URL', 'https://yaycommerce.com/yaymail-addons/yaymail-premium-addon-for-woocommerce-subscriptions/' );
}

if ( ! defined( 'YAYMAIL_ADDON_PLUGIN_NAME' ) ) {
	define( 'YAYMAIL_ADDON_PLUGIN_NAME', 'wc_subscription' );
}

if ( ! defined( 'YAYMAIL_ADDON_PLUGIN_NAME_VERSION' ) ) {
	define( 'YAYMAIL_ADDON_PLUGIN_NAME_VERSION', '1.0' );
}

if ( ! defined( 'YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL' ) ) {
	define( 'YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH' ) ) {
	define( 'YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_BASENAME' ) ) {
	define( 'YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_DATA' ) ) {
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	define( 'YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_DATA', get_plugin_data( __FILE__ ) );
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

function init() {
	Backend\Enqueue::get_instance();
	Core\YayMailAddonController::get_instance();
}

add_action( 'plugins_loaded', 'YayMailAddon\\init' );
