<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

	$border_color = isset( $attrs['borderColor'] ) && $attrs['borderColor'] ? 'border-color:' . html_entity_decode( $attrs['borderColor'], ENT_QUOTES, 'UTF-8' ) : 'border-color:inherit';
	$text_color   = isset( $attrs['textColor'] ) && $attrs['textColor'] ? 'color:' . html_entity_decode( $attrs['textColor'], ENT_QUOTES, 'UTF-8' ) : 'color:inherit';

	$subscript_title_subscription = isset( $attrs['titleSubscription '] ) ? $attrs['titleSubscription '] : 'Subscription';
	$subscript_product            = isset( $attrs['titleProduct'] ) ? $attrs['titleProduct'] : 'Product';
	$subscript_quantity           = isset( $attrs['titleQuantity'] ) ? $attrs['titleQuantity'] : 'Quantity';
	$subscript_price              = isset( $attrs['titlePrice'] ) ? $attrs['titlePrice'] : 'Price';
	$subscript_subtotal           = isset( $attrs['titleSubtotal'] ) ? $attrs['titleSubtotal'] : 'Subtotal';
	$subscript_discount           = isset( $attrs['titleDiscount'] ) ? $attrs['titleDiscount'] : 'Discount';
	$subscript_shipping           = isset( $attrs['titleShipping'] ) ? $attrs['titleShipping'] : 'Shipping';
	$subscript_payment_method     = isset( $attrs['titlePaymentMethod'] ) ? $attrs['titlePaymentMethod'] : 'Payment Method';
	$subscript_total              = isset( $attrs['titleTotal'] ) ? $attrs['titleTotal'] : 'Total';
?>

<table
  width="<?php esc_attr_e( $general_attrs['tableWidth'], 'woocommerce' ); ?>"
  cellspacing="0"
  cellpadding="0"
  border="0"
  align="center"
  style="display: table; <?php echo esc_attr( 'background-color: ' . $attrs['backgroundColor'] ); ?>;<?php echo esc_attr( 'min-width: ' . $general_attrs['tableWidth'] . 'px' ); ?>;"
  class="web-main-row"
  id="web<?php echo esc_attr( $id ); ?>"
  >
  <tbody>
	  <tr>
		<td
		  id="web-<?php echo esc_attr( $id ); ?>-order-item"
		  class="web-order-item"
		  align="left"
		  style='font-size: 13px; line-height: 22px; word-break: break-word;
		  <?php echo 'font-family: ' . wp_kses_post( $attrs['family'] ); ?>;
		  <?php echo esc_attr( 'padding: ' . $attrs['paddingTop'] . 'px ' . $attrs['paddingRight'] . 'px ' . $attrs['paddingBottom'] . 'px ' . $attrs['paddingLeft'] . 'px;' ); ?>
		  '
		>
		  <div
			style="min-height: 10px; <?php echo esc_attr( 'color: ' . $attrs['textColor'] ); ?>;"
		  >
				<h2 class="yaymail_builder_order yaymail_subscription_table_title" style='<?php echo 'font-family: ' . wp_kses_post( $attrs['family'] ); ?>;font-size: 18px; font-weight: 700; <?php echo esc_attr( 'color: ' . $attrs['titleColor'] ); ?>'>
					<?php echo esc_html_e( $subscript_title_subscription, 'woocommerce-subscriptions' ); ?>
					<a href="#" style="<?php echo esc_attr( 'color: ' . $attrs['titleColor'] ); ?>"><?php echo esc_html( '#1' ); ?></a>
				</h2>            
				<table class="yaymail_builder_table_items_border yaymail_builder_table_subcription yaymail_new_subscription_detail_content" cellspacing="0" cellpadding="6" border="1" style="width: 100% !important;<?php echo esc_attr( $border_color ); ?>;color: inherit;flex-direction:inherit;" width="100%">
					<thead>
						<tr style="word-break: normal;<?php echo esc_attr( $text_color ); ?>">
							<th class="td yaymail_subscription_produc_title" scope="col" style='<?php echo 'font-family: ' . wp_kses_post( $attrs['family'] ); ?>;text-align:left;<?php echo esc_attr( $border_color ); ?>;'><?php esc_html_e( $subscript_product, 'woocommerce-subscriptions' ); ?></th>
							<th class="td yaymail_subscription_quantity_title" scope="col" style='<?php echo 'font-family: ' . wp_kses_post( $attrs['family'] ); ?>;text-align:left;<?php echo esc_attr( $border_color ); ?>;'><?php echo esc_html_x( $subscript_quantity, 'table headings in notification email', 'woocommerce-subscriptions' ); ?></th>
							<th class="td yaymail_subscription_price_title" scope="col" style='<?php echo 'font-family: ' . wp_kses_post( $attrs['family'] ); ?>;text-align:left;<?php echo esc_attr( $border_color ); ?>;'><?php echo esc_html_x( $subscript_price, 'table heading', 'woocommerce-subscriptions' ); ?></th>
						</tr>
					</thead>

					<tbody style="flex-direction:inherit;" style="flex-direction:inherit;<?php echo esc_attr( 'color: ' . $attrs['textColor'] ); ?>;<?php echo esc_attr( $border_color ); ?>;">
						<tr class="yaymail_subscription_order_item" style="flex-direction:inherit;<?php echo esc_attr( 'color: ' . $attrs['textColor'] ); ?>;<?php echo esc_attr( $border_color ); ?>;">
							<th colspan="<?php echo wp_kses_post( apply_filters( 'yaymail_order_item_product_title_colspan', 1, $yaymail_template ) ); ?>" class="td yaymail_item_product_content" scope="row" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;<?php echo esc_attr( $border_color ); ?>;">
								<?php esc_html_e( 'Happy YayCommerce', 'yaymail' ); ?>
							</th>
							<th colspan="<?php echo wp_kses_post( apply_filters( 'yaymail_order_item_quantity_colspan', 1, $yaymail_template ) ); ?>" class="td yaymail_item_quantity_content" scope="row" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;<?php echo esc_attr( $border_color ); ?>;">
								<?php esc_html_e( 1, 'yaymail' ); ?>
							<th colspan="<?php echo wp_kses_post( apply_filters( 'yaymail_order_item_price_colspan', 1, $yaymail_template ) ); ?>" class="td yaymail_item_price_content" scope="row" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;<?php echo esc_attr( $border_color ); ?>;">
								<?php esc_html_e( '£18.00', 'yaymail' ); ?>
							</th>
						</tr>
					</tbody>
					<tfoot>
					<tr>
						<th class="td yaymail_subscription_subtoltal_title" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;font-weight: bold;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid; ;border-top-width: 4px;">
							<?php esc_html_e( $subscript_subtotal, 'woocommerce' ); ?>
						</th>
						<th class="td yaymail_subscription_subtoltal_content" scope="row" colspan="1" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;; border-top-width: 4px;">
							<?php esc_html_e( '£18.00', 'yaymail' ); ?>
						</th>
					</tr>
					<tr>
						<th class="td yaymail_subscription_payment_method_title" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; font-weight: bold;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
							<?php esc_html_e( $subscript_payment_method, 'woocommerce' ); ?>
						</th>
						<th class="td yaymail_subscription_payment_method_content" scope="row" colspan="1" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
							<?php esc_html_e( 'Direct bank transfer', 'woocommerce' ); ?>
						</th>
					</tr>
					<tr>
						<th class="td yaymail_subscription_total_title" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; font-weight: bold;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
							<?php esc_html_e( $subscript_total, 'woocommerce' ); ?>
						</th>
						<th class="td yaymail_subscription_total_content" scope="row" colspan="1" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
							<?php esc_html_e( '£18.00', 'yaymail' ); ?>
						</th>
					</tr>
					</tfoot>
				</table>

			<!-- Table Subscription Cancelled -->
		  </div>
		</td>
	  </tr>
	</tbody>
</table>
