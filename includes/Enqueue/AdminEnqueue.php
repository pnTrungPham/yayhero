<?php
namespace WPInternalLinks\Enqueue;

use WPInternalLinks\Utils\SingletonTrait;

/**
 * @method static AdminEnqueue get_instance()
 */
class AdminEnqueue {

    use SingletonTrait;

    /**
     * The Constructor that load the engine classes
     */
    protected function __construct() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );

        wp_enqueue_style( 'wp-internal-links-admin', WP_INTERNAL_LINKS_PLUGIN_URL . 'assets/admin/css/admin.css', [], WP_INTERNAL_LINKS_VERSION );
        wp_enqueue_script( 'wp-internal-links-admin', WP_INTERNAL_LINKS_PLUGIN_URL . 'assets/admin/js/admin.js', [ 'jquery', 'jquery-ui-dialog' ], WP_INTERNAL_LINKS_VERSION, true );
        wp_localize_script(
            'wp-internal-links-admin',
            'wp_internal_links',
            [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'wp-internal-links-nonce' ),
            ]
        );
    }
}
