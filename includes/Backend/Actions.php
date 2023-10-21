<?php

namespace YayMailAddon\Backend;

defined( 'ABSPATH' ) || exit;

class Actions {

	public static function initialize() {
		add_filter( 'plugin_action_links_' . YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_BASENAME, array( __CLASS__, 'yaymail_addon_add_action_links' ) );
		add_filter( 'plugin_row_meta', array( __CLASS__, 'yaymail_addon_custom_plugin_row_meta' ), 10, 2 );
	}

	public static function yaymail_addon_custom_plugin_row_meta( $plugin_meta, $plugin_file ) {

		if ( strpos( $plugin_file, YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_BASENAME ) !== false ) {
			$new_links = array(
				'docs'    => '<a href="https://yaycommerce.gitbook.io/yaymail/" aria-label="' . esc_attr__( 'View YayMail documentation', 'yaymail' ) . '">' . esc_html__( 'Docs', 'yaymail' ) . '</a>',
				'support' => '<a href="https://yaycommerce.com/support/" aria-label="' . esc_attr__( 'Visit community forums', 'yaymail' ) . '">' . esc_html__( 'Support', 'yaymail' ) . '</a>',
			);

			$plugin_meta = array_merge( $plugin_meta, $new_links );
		}

		return $plugin_meta;
	}

	public static function yaymail_addon_add_action_links( $actions ) {
		if ( defined( 'YAYMAIL_PREFIX' ) ) {
			$links   = array(
				'<a href="' . admin_url( 'admin.php?page=yaymail-settings' ) . '" aria-label="' . esc_attr__( 'View WooCommerce Email Builder', 'yaymail' ) . '">' . esc_html__( 'Start Customizing', 'yaymail' ) . '</a>',
			);
			$actions = array_merge( $links, $actions );
		}
		return $actions;
	}
}
