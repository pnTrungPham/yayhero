<?php

namespace YayMailAddon\Backend;

defined( 'ABSPATH' ) || exit;

class Enqueue {
	protected static $instance = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->do_hooks();
		}

		return self::$instance;
	}

	private function do_hooks() {
		add_action('wp_enqueue_scripts', array(__CLASS__, 'wp_enqueue_scripts1'));
	}

	public static function wp_enqueue_scripts1() {
		if (get_the_ID() === 58042) {
			wp_register_style('trung-home', YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/frontend/style.css', array());
			wp_enqueue_style('trung-home');
	
			wp_register_script('trung-home', YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/frontend/main.js', array('jquery'),'1.0', true );
			wp_enqueue_script('trung-home');
		}

		if (get_the_ID() ===  58047) {
			wp_register_style('trung-cute', YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/frontend/cute.css', array());
			wp_enqueue_style('trung-cute');
	
			wp_register_script('trung-cute', YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/frontend/cute.js', array('jquery'),'1.0', true );
			wp_enqueue_script('trung-cute');
		}
	}
}
