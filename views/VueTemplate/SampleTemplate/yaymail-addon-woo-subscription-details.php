<?php
	$text_align       = is_rtl() ? 'right' : 'left';
	$sent_to_admin    = ( isset( $sent_to_admin ) ? true : false );
	$plain_text       = ( isset( $plain_text ) ? $plain_text : '' );
	$email            = ( isset( $email ) ? $email : '' );
	$text_link_color  = get_post_meta( $post_id, '_yaymail_email_textLinkColor_settings', true ) ? get_post_meta( $post_id, '_yaymail_email_textLinkColor_settings', true ) : '#7f54b3';
	$order_item_title = get_post_meta( $post_id, '_yaymail_email_order_item_title', true );
?>

<table
	:width="tableWidth"
	cellspacing="0"
	cellpadding="0"
	border="0"
	align="center"
	style="display: table;width: 100%;"
	:style="{
	  backgroundColor: emailContent.settingRow.backgroundColor,
	  width: tableWidth
	}"
	class="web-main-row"
	:id="'web' + emailContent.id"
  >
	  <tbody>
	  <tr>
		<td
		  :id="'web-' + emailContent.id + '-order-item'"
		  class="web-order-item"
		  align="left"
		  style="font-size: 13px; line-height: 22px; word-break: break-word;"
		  :style="{
			fontFamily: emailContent.settingRow.family,
			paddingTop: emailContent.settingRow.paddingTop + 'px',
			paddingBottom: emailContent.settingRow.paddingBottom + 'px',
			paddingRight: emailContent.settingRow.paddingRight + 'px',
			paddingLeft: emailContent.settingRow.paddingLeft + 'px'
		  }"
		>
		  <div
		  class="yaymail-items-order-border"
			style="min-height: 10px"
			:style="{
			  color: emailContent.settingRow.textColor,
			  borderColor: emailContent.settingRow.borderColor,
			}"
		  >
			<h2 class="yaymail_builder_order yaymail_subscription_table_title" style="font-size: 18px; font-weight: 700;" :style="{color: emailContent.settingRow.titleColor}">
			  {{emailContent.settingRow.titleSubscription}} 
			  <a href="#" :style="{color: emailContent.settingRow.titleColor}">#1</a>
			</h2>
		
				<table class="yaymail_builder_table_items_border yaymail_builder_table_subcription yaymail_subscription_cancelled_content" 
						cellspacing="0" cellpadding="6" border="1" 
						style="width: 100% !important;color: inherit;flex-direction:inherit;" width="100%" :style="{'border-color': emailContent.settingRow.borderColor}">
					<thead>
						<tr style="word-break: normal;" :style="{color: emailContent.settingRow.textColor}">
							<th class="td yaymail_subscription_product_title" scope="col" style="text-align:left;" :style="{'border-color': emailContent.settingRow.borderColor}">{{emailContent.settingRow.titleProduct}}</th>
							<th class="td yaymail_subscription_quantity_title" scope="col" style="text-align:left;" :style="{'border-color': emailContent.settingRow.borderColor}">{{emailContent.settingRow.titleQuantity}}</th>
							<th class="td yaymail_subscription_price_title" scope="col" style="text-align:left;" :style="{'border-color': emailContent.settingRow.borderColor}">{{emailContent.settingRow.titlePrice}}</th>
						</tr>
					</thead>

					<tbody style="flex-direction:inherit;" style="flex-direction:inherit;" :style="{color: emailContent.settingRow.textColor}">
						<tr class="yaymail_subscription_order_item">
							<th colspan="1" class="td yaymail_item_product_content" scope="row" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
								<?php esc_html_e( 'Happy YayCommerce', 'yaymail' ); ?>
							</th>
							<th colspan="1" class="td yaymail_item_quantity_content" scope="row" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
								<?php esc_html_e( 1, 'yaymail' ); ?>
							<th colspan="1" class="td yaymail_item_price_content" scope="row" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
								<?php esc_html_e( '£18.00', 'yaymail' ); ?>
							</th>
						</tr>
					</tbody>
					<tfoot>
					<tr>
						<th class="td yaymail_subscription_subtoltal_title" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;font-weight: bold;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid; ;border-top-width: 4px;">
							{{emailContent.settingRow.titleSubtotal}}
						</th>
						<th class="td yaymail_subscription_subtoltal_content" scope="row" colspan="1" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;; border-top-width: 4px;">
							<?php esc_html_e( '£18.00', 'yaymail' ); ?>
						</th>
					</tr>
					<tr>
						<th class="td yaymail_subscription_payment_method_title" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; font-weight: bold;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
							{{emailContent.settingRow.titlePaymentMethod}}
						</th>
						<th class="td yaymail_subscription_payment_method_content" scope="row" colspan="1" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
							<?php esc_html_e( 'Direct bank transfer', 'woocommerce' ); ?>
						</th>
					</tr>
					<tr>
						<th class="td yaymail_subscription_total_title" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; font-weight: bold;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
							{{emailContent.settingRow.titleTotal}}
						</th>
						<th class="td yaymail_subscription_total_content" scope="row" colspan="1" style="font-weight: normal;text-align:<?php echo esc_attr( $text_align ); ?>;vertical-align: middle;padding: 12px;font-size: 14px;border-width: 1px;border-style: solid;">
							<?php esc_html_e( '£18.00', 'yaymail' ); ?>
						</th>
					</tr>
					</tfoot>
				</table>
			
		</div>
	</td>
	</tr>
</tbody>
</table>

