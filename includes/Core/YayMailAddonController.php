<?php

namespace YayMailAddon\Core;

defined( 'ABSPATH' ) || exit;

class YayMailAddonController {
	protected static $instance = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->do_hooks();
		}

		return self::$instance;
	}

	private function do_hooks() {
		add_shortcode('thanh_thanh', array( $this, 'shortcode_function' ));
		add_shortcode('thanh_thanh_2', array( $this, 'shortcode_function_2' ));
	}

	public function shortcode_function () {
		include YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH . '/views/template/home.php';
	}

	public function shortcode_function_2 () {
		include YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH . '/views/template/cute.php';
	}
}
