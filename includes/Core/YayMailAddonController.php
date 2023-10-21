<?php

namespace YayMailAddon\Core;

defined( 'ABSPATH' ) || exit;

use YayMailAddon\TemplateDefault\DefaultSubscription;

class YayMailAddonController {
	protected static $instance = null;
	private $template_email_id = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->do_hooks();
		}

		return self::$instance;
	}

	private function do_hooks() {
		$this->template_email_id = array(
			'cancelled_subscription',
			'expired_subscription',
			'suspended_subscription',
			'customer_completed_renewal_order',
			'customer_completed_switch_order',
			'customer_on_hold_renewal_order',
			'customer_renewal_invoice',
			'new_renewal_order',
			'new_switch_order',
			'customer_processing_renewal_order',
			'customer_payment_retry',
			'payment_retry',
			'_enr_customer_auto_renewal_reminder',
			'_enr_customer_expiry_reminder',
			'_enr_customer_manual_renewal_reminder',
			'_enr_customer_processing_shipping_fulfilment_order',
			'_enr_customer_shipping_frequency_notification',
			'_enr_customer_subscription_price_updated',
			'_enr_customer_trial_ending_reminder',
		);

		YayMailAddonElementRender::get_instance( $this->template_email_id );
		add_filter( 'yaymail_addon_get_updated_elements', array( $this, 'yaymail_addon_get_updated_elements' ), 10, 1 );
		add_filter( 'YaymailNewTempalteDefault', array( $this, 'yaymail_new_template_default' ), 100, 3 );
		add_filter( 'yaymail_addon_defined_shorcode', array( $this, 'yaymail_addon_defined_shorcode' ) );
		add_filter( 'yaymail_addon_defined_template', array( $this, 'yaymail_addon_defined_template' ), 100, 2 );
	}

	public function yaymail_addon_defined_template( $result, $template ) {
		$template_email_id = $this->template_email_id;
		if ( in_array( $template, $template_email_id ) ) {
			return true;
		}
		return $result;
	}

	/*
	Action to defined shortcode
	$arrData[0] : $custom_shortcode
	$arrData[1] : $args
	$arrData[2] : $templateName
	*/
	public function yaymail_addon_defined_shorcode( $arr_data ) {
		$template_email_id = $this->template_email_id;
		if ( in_array( $arr_data[2], $template_email_id ) ) {
			$arr_data[0]->setOrderId( isset( $arr_data[1]['subscription'] ) && null !== $arr_data[1]['subscription'] ? $arr_data[1]['subscription']->get_data()['parent_id'] : 0, $arr_data[1]['sent_to_admin'], $arr_data[1] );
			$arr_data[0]->shortCodesOrderDefined( $arr_data[1]['sent_to_admin'], $arr_data[1] );
		}
	}

	public function yaymail_new_template_default( $array, $key, $value ) {
		$get_heading = isset( $value->heading ) ? $value->heading : '';
		if ( 'WCS_Email_New_Switch_Order' == $key
		|| 'WCS_Email_Completed_Switch_Order' == $key
		|| 'WCS_Email_Cancelled_Subscription' == $key
		|| 'WCS_Email_Expired_Subscription' == $key
		|| 'WCS_Email_On_Hold_Subscription' == $key
		|| 'ENR_Email_Customer_Expiry_Reminder' == $key
		|| 'ENR_Email_Customer_Subscription_Price_Updated' == $key
		|| 'ENR_Email_Customer_Trial_Ending_Reminder' == $key
		|| 'WCS_Email_Completed_Renewal_Order' == $key
		|| 'WCS_Email_Customer_On_Hold_Renewal_Order' == $key
		|| 'WCS_Email_Customer_Renewal_Invoice' == $key
		|| 'WCS_Email_New_Renewal_Order' == $key
		|| 'WCS_Email_Processing_Renewal_Order' == $key
		|| 'WCS_Email_Customer_Payment_Retry' == $key
		|| 'WCS_Email_Payment_Retry' == $key
		|| 'ENR_Email_Customer_Auto_Renewal_Reminder' == $key
		|| 'ENR_Email_Customer_Manual_Renewal_Reminder' == $key
		|| 'ENR_Email_Customer_Processing_Shipping_Fulfilment_Order' == $key
		|| 'ENR_Email_Customer_Shipping_Frequency_Notification' == $key
		) {
			$defaultSubscription                        = DefaultSubscription::get_templates( $value->id, $get_heading );
			$defaultSubscription[ $value->id ]['title'] = __( $value->title, 'woocommerce' );
			return $defaultSubscription;
		}
		return $array;
	}

	public static function yaymail_addon_get_updated_elements( $element ) {
		$result = array_merge( $element, array() );
		return $result;
	}
}
