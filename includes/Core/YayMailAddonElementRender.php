<?php

namespace YayMailAddon\Core;

defined( 'ABSPATH' ) || exit;

use YayMail\Helper\Helper;

class YayMailAddonElementRender {
	protected static $instance = null;
	private $template_email_id = null;
	public static function get_instance( $template_email_id ) {
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->do_hooks( $template_email_id );
		}

		return self::$instance;
	}

	private function do_hooks( $template_email_id ) {
		$this->template_email_id = $template_email_id;
		add_filter( 'yaymail_plugins', array( $this, 'yaymail_plugins' ), 10, 1 );
		add_filter( 'yaymail_addon_templates', array( $this, 'yaymail_addon_templates' ), 100, 3 );
		$this->do_hook_vue_render();
		$this->do_hook_element_render();
	}

	public function yaymail_plugins( $plugins ) {
		$plugins[] = array(
			'plugin_name'      => YAYMAIL_ADDON_PLUGIN_NAME, // --> CHANGE HERE => name of plugin (maybe name of the class)
			'addon_components' => array(
				'WooSubscriptionInformation',
				'WooSubscriptionSuspended',
				'WooSubscriptionExpired',
				'WooSubscriptionCancelled',
				'WooSubscriptionCustomerExpiryReminder',
				'WooSubscriptionPriceUpdated',
				'WooSubscriptionTrialEndingReminder',
				'WooSubscriptionNewDetails',
				'WooSubscriptionDetails',
			), // CHANGE HERE => main-name required
			'template_name'    => $this->template_email_id,
		);
		return $plugins;
	}

	// Filter to add template to Vuex
	public static function yaymail_addon_templates( $addon_templates, $order, $post_id ) {
		$components = apply_filters( 'yaymail_plugins', array() );
		$position   = '';
		foreach ( $components as $key => $component ) {
			if ( YAYMAIL_ADDON_PLUGIN_NAME === $component['plugin_name'] ) {
				$position = $key;
				break;
			}
		}
		foreach ( $components[ $position ]['addon_components'] as $key => $component ) {
			ob_start();
			do_action( 'YaymailAddon' . $component . 'Vue', $order, $post_id );
			$html = ob_get_contents();
			ob_end_clean();
			$addon_templates[ YAYMAIL_ADDON_PLUGIN_NAME ] = array_merge( isset( $addon_templates[ YAYMAIL_ADDON_PLUGIN_NAME ] ) ? $addon_templates[ YAYMAIL_ADDON_PLUGIN_NAME ] : array(), array( $component . 'Vue' => $html ) );
		}
		return $addon_templates;
	}

	// Create HTML with Vue syntax to display in Vue
	// CHANGE HERE => Name of action follow : YaymailAddon + main-name + Vue
	// CHANGE SOURCE VUE TOO
	private function do_hook_vue_render() {
		add_action( 'YaymailAddonWooSubscriptionInformationVue', array( $this, 'woo_subscription_information_vue' ), 100, 2 );
	}

	// Create HTML to display when send mail
	// CHANGE HERE => Name of action follow: YaymailAddon + main-name
	private function do_hook_element_render() {
		add_action( 'YaymailAddonWooSubscriptionInformation', array( $this, 'woo_subscription_information' ), 100, 5 );
	}

	//-------------- Vue Element Render -----------//

	public function woo_subscription_information_vue( $order, $post_id = '' ) {
		if ( class_exists( 'WC_Subscription' ) ) {
			if ( '' === $order ) {
				ob_start();
				include YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH . '/views/VueTemplate/yaymail-addon-woo-subscription-information.php';
				$html = ob_get_contents();
				ob_end_clean();
			} else {
				ob_start();
				include YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH . '/views/VueTemplate/yaymail-addon-woo-subscription-information.php';
				$html = ob_get_contents();
				ob_end_clean();
				if ( '' === $html ) {
					$html = '<div></div>';
				}
			}
			$html              = Helper::replaceCustomAllowedHTMLTags( $html );
			$allowed_html_tags = Helper::customAllowedHTMLTags( array( 'yaymail-style' => true ) );
			echo wp_kses( $html, $allowed_html_tags );
		}
	}

	//-------------- Element Render -----------//

	public function woo_subscription_information( $args = array(), $attrs = array(), $general_attrs = array(), $id = '', $post_id = '' ) {
		if ( class_exists( 'WC_Subscription' ) ) {
			if ( isset( $args['order'] ) ) {
				ob_start();
				$order = $args['order'];
				include YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_PATH . '/views/Template/yaymail-addon-order-subscription.php';
				$html = ob_get_contents();
				ob_end_clean();
				$html = do_shortcode( $html );
				echo wp_kses_post( $html );
			} else {
				echo wp_kses_post( '' );
			}
		}
	}
}
