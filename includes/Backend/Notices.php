<?php

namespace YayMailAddon\Backend;

defined( 'ABSPATH' ) || exit;

class Notices {
	public static function initialize() {
		add_action( 'after_plugin_row_' . YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_BASENAME, array( __CLASS__, 'install_plugin_notice' ), 10, 2 );
	}

	public static function install_plugin_notice( $plugin_file, $plugin_data ) {
		$wp_list_table = _get_list_table( 'WP_MS_Themes_List_Table' );
		?>
		<script>
		var plugin_row_element = document.querySelector('tr[data-plugin="<?php echo esc_js( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_BASENAME ); ?>"]');
		plugin_row_element.classList.add('update');
		</script>
		<?php
		$notice_addon = '<div class="notice inline notice-warning notice-alt"><p>';
		// Translators: Placeholders are opening and closing Addon Name tags.
		$notice_addon .= sprintf( esc_html__( 'In order to customize templates of %1$s, please install %2$s first.', 'yaymail' ), '<strong>' . YAYMAIL_ADDON_PLUGIN_NAME_NAME . '</strong>', '<strong>' . YAYMAIL_ADDON_PLUGIN_NAME_NAME . '</strong>' );
		$notice_addon .= '</p> </div>';

		$notice_yaymail  = '<div class="notice inline notice-warning notice-alt"><p>';
		$notice_yaymail .= esc_html__( 'To use this addon, you need to install and activate YayMail plugin. Get ', 'yaymail' ) . '<a href="' . esc_url( 'https://wordpress.org/plugins/yaymail/' ) . '">' . esc_html__( 'YayMail Free', 'yaymail' ) . '</a> or <a href="' . esc_url( 'https://yaycommerce.com/yaymail-woocommerce-email-customizer/' ) . '">' . esc_html__( 'YayMail Pro', 'yaymail' ) . '</a>';
		$notice_yaymail .= '</p> </div>';

		echo wp_kses_post( '<tr class="plugin-update-tr' . ( is_plugin_active( $plugin_file ) ? ' active' : '' ) . '"><td colspan="' . esc_attr( $wp_list_table->get_column_count() ) . '" class="plugin-update colspanchange" >' );
		if ( ! function_exists( 'YayMail\\init' ) ) {
			echo wp_kses_post( $notice_yaymail );
		}
		if ( ! YAYMAIL_THIRD_PARTY_PLUGIN_NAME_IS_ACTIVE ) {
			echo wp_kses_post( $notice_addon );
		}
		echo wp_kses_post( '</td></tr>' );

	}

}
