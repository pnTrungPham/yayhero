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

            if ( 'inbound' === $link_type ) {
                $html = $this->get_inbound_links_html( $post_id );
            } else {
                $html = $this->get_outbound_links_html( $post_id );
            }

            wp_send_json_success( [ 'html' => $html ] );
        } catch ( \Exception $e ) {
            wp_send_json_error( [ 'message' => $e->getMessage() ] );
        }
    }

    public function get_inbound_links_html( $post_id ) {
        $links = InternalLinksController::get_inbound_internal_links( $post_id );
        $html  = '<table>';
        $html .= '<thead><tr><th>Title</th><th>Type</th><th>Categories</th></tr></thead>';
        $html .= '<tbody>';
        foreach ( $links as $link ) {
            $html .= '<tr>';
            $html .= '<td><a href="' . get_edit_post_link( $link['ID'] ) . '">' . $link['title'] . '</a></td>';
            $html .= '<td>' . ucfirst( $link['type'] ) . '</td>';
            $html .= '<td>' . $link['categories'] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        return $html;
    }

    public function get_outbound_links_html( $post_id ) {
        $links = InternalLinksController::get_outbound_internal_links( $post_id );
        $html  = '<table>';
        $html .= '<thead><tr><th>Title</th><th>Type</th><th>Categories</th></tr></thead>';
        $html .= '<tbody>';
        foreach ( $links as $link ) {
            $html .= '<tr>';
            $html .= '<td><a href="' . get_edit_post_link( $link['ID'] ) . '">' . $link['title'] . '</a></td>';
            $html .= '<td>' . ucfirst( $link['type'] ) . '</td>';
            $html .= '<td>' . $link['categories'] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        return $html;
    }

}
