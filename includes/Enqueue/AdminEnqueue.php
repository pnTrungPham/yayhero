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
        wp_enqueue_style( 'wp-internal-links-admin', WP_INTERNAL_LINKS_PLUGIN_URL . 'assets/admin/css/admin.css', [], '1.0' );
        wp_enqueue_script( 'wp-internal-links-admin', WP_INTERNAL_LINKS_PLUGIN_URL . 'assets/admin/js/admin.js', [ 'jquery' ], '1.0', true );
    }
}
