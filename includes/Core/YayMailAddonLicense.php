<?php

namespace YayMailAddon\Core;

defined( 'ABSPATH' ) || exit;

class YayMailAddonLicense {
	public static function initialize() {
		add_filter( 'yaymail_available_licensing_plugins', array( __CLASS__, 'yaymail_addon_license' ) );
	}

	public static function yaymail_addon_license( $plugins ) {
		$plugin_data    = YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_DATA;
		$plugin_version = $plugin_data['Version'];
		$plugin_name    = $plugin_data['Name'];
		$plugin_slug    = strtolower( str_replace( ' ', '_', $plugin_name ) );
		$plugins[]      = array(
			'name'     => $plugin_name,
			'slug'     => $plugin_slug,
			'dir_path' => YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH,
			'basename' => YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_BASENAME,
			'url'      => YAYMAIL_ADDON_PLUGIN_NAME_LINK_URL,
			'file'     => __FILE__,
			'version'  => $plugin_version,
			'item_id'  => '6795',
		);
		return $plugins;
	}
}
