<?php
namespace WPInternalLinks;

use WPInternalLinks\Utils\SingletonTrait;
use WPInternalLinks\Controllers\InternalLinksController;

/**
 *
 * @method static Ajax get_instance()
 */
class Ajax {

    use SingletonTrait;

    /**
     * The Constructor that load the engine classes
     */
    protected function __construct() {
        add_action( 'wp_ajax_get_internal_links_info', [ $this, 'get_internal_links_info_callback' ] );
        add_action( 'wp_ajax_nopriv_get_internal_links_info', [ $this, 'get_internal_links_info_callback' ] );
    }

    public function get_internal_links_info_callback() {
        try {
            $nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
            if ( ! wp_verify_nonce( $nonce, 'wp-internal-links-nonce' ) ) {
                wp_send_json_error( [ 'mess' => __( 'Nonce is invalid', 'wpinternallinks' ) ] );
            }

            $post_id   = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
            $link_type = isset( $_POST['link_type'] ) ? sanitize_text_field( $_POST['link_type'] ) : 'inbound';

            $get_popup_info = $this->get_popup_info_html( $post_id, $link_type ) ?? '';
            $html           = $get_popup_info['html'] ?? '';
            $title          = $get_popup_info['title'] ?? '';
            wp_send_json_success(
                [
                    'html'  => $html,
                    'title' => $title,
                ]
            );
        } catch ( \Exception $e ) {
            wp_send_json_error( [ 'message' => $e->getMessage() ] );
        }
    }

    public function get_popup_info_html( $post_id, $link_type ) {
        $post       = get_post( $post_id );
        $post_title = $post->post_title;

        if ( 'inbound' === $link_type ) {
            $title = __( 'Internal Links [Entire WebSite] - Inbound', 'wpinternallinks' );
            $links = InternalLinksController::get_inbound_internal_links( $post_id );
        }
        if ( 'outbound' === $link_type ) {
            $title = __( 'Internal Links [Entire WebSite] - Inbound', 'wpinternallinks' );
            $links = InternalLinksController::get_outbound_internal_links( $post_id );
        }
        if ( 'inbound_category' === $link_type ) {
            $title = __( 'Internal Links [Within the Category] - Inbound', 'wpinternallinks' );
            $links = InternalLinksController::get_inbound_internal_links_in_category( $post_id );
        }
        if ( 'outbound_category' === $link_type ) {
            $title = __( 'Internal Links [Within the Category] - Inbound', 'wpinternallinks' );
            $links = InternalLinksController::get_outbound_internal_links_in_category( $post_id );
        }

        if ( ! empty( $links ) && ! empty( $post_title ) ) {
            ob_start();
            include WP_INTERNAL_LINKS_PLUGIN_PATH . 'templates/dashboard/popup-info.php';
            $html = ob_get_contents();
            ob_end_clean();

            return [
                'html'  => $html,
                'title' => $title,
            ];
        }
        return '';
    }

}
