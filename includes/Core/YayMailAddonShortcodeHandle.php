<?php

namespace YayMailAddon\Core;

defined( 'ABSPATH' ) || exit;

class YayMailAddonShortcodeHandle {
	protected static $instance = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->do_hooks();
		}

		return self::$instance;
	}

	private function do_hooks() {
		add_filter( 'yaymail_shortcodes', array( $this, 'yaymail_shortcodes' ), 10, 1 );
		add_filter( 'yaymail_do_shortcode', array( $this, 'yaymail_do_shortcode' ), 10, 3 );
		add_filter( 'yaymail_list_shortcodes', array( $this, 'yaymail_list_shortcodes' ), 10, 1 );
	}

	public static function yaymail_list_shortcodes( $shortcode_list ) {
		$shortcode_list[] = array(
			'plugin'    => 'WooCommerce Subscription',
			'shortcode' => array(
				array( '[yaymail_addon_order_subscription]', 'Wallet User New Transaction' ),
			),
		);

		return $shortcode_list;
	}

	public static function yaymail_shortcodes( $shortcode_list ) {
		$shortcode_list[] = 'yaymail_addon_order_subscription';
		return $shortcode_list;
	}

	public function yaymail_do_shortcode( $shortcode_list, $yaymail_informations, $args = array() ) {
		$shortcode_list['[yaymail_addon_order_subscription]'] = $this->yaymail_addon_order_subscription( $yaymail_informations, $args );
		return $shortcode_list;
	}

	public function yaymail_addon_order_subscription( $yaymail_informations, $args = array() ) {
		ob_start();
		include YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH . '/views/Template/yaymail-addon-order-subscription.php';
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

}
