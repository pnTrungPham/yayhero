<?php

namespace WPSource\Enqueue;

use WPSource\Utils\SingletonTrait;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Classes
 */
class Admin {
    use SingletonTrait;

    protected function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'wpsource_admin_enqueue' ] );
    }

    public function wpsource_admin_enqueue() {
        $this->enqueue_jquery_ui();
        $this->enqueue_elfinder();

        wp_localize_script(
            'wpsource-elfinder-js',
            'wps_connector_data',
            [
                'admin_ajax' => admin_url( 'admin-ajax.php' ),
                'nonce'      => wp_create_nonce( 'wpsource-admin-nonce' ),
            ]
        );
    }

    public function enqueue_jquery_ui() {
        wp_enqueue_style( 'wpsource-jq-ui-css', RPFM_PLUGIN_URL . 'includes/ElFinder/jquery/jquery-ui.min.css', [], RPFM_VERSION, true );

        if ( version_compare( get_bloginfo( 'version' ), '5.6', '>=' ) ) {
            wp_enqueue_script( 'wpsource-jq-ui-js', RPFM_PLUGIN_URL . 'includes/ElFinder/jquery/jquery-ui.min.js', [], RPFM_VERSION, true );
        } else {
            wp_enqueue_script( 'wpsource-jq-ui-js', RPFM_PLUGIN_URL . 'includes/ElFinder/jquery/jquery-ui-old.min.js', [], RPFM_VERSION, true );
        }
    }

    public function enqueue_elfinder() {
        wp_enqueue_script( 'wpsource-elfinder-css', RPFM_PLUGIN_URL . 'includes/ElFinder/css/elfinder.min.css', [], RPFM_VERSION, true );
        wp_enqueue_script( 'wpsource-elfinder-js', RPFM_PLUGIN_URL . 'includes/ElFinder/js/elfinder.full.js', [], RPFM_VERSION );
        wp_enqueue_script( 'wpsource-elfinder-editor', RPFM_PLUGIN_URL . 'includes/ElFinder/js/extras/editors.default.min.js', [], RPFM_VERSION );
        wp_enqueue_script( 'wpsource-elfinder-lang', RPFM_PLUGIN_URL . 'includes/ElFinder/js/i18n/elfinder.LANG.js', [], RPFM_VERSION );
    }

}
