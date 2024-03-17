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
        wp_enqueue_style( 'wpsource-jq-ui-css', WP_SOURCE_FM_PLUGIN_URL . 'includes/ElFinder/jquery/jquery-ui.min.css', [], WP_SOURCE_FM_VERSION, true );

        if ( version_compare( get_bloginfo( 'version' ), '5.6', '>=' ) ) {
            wp_enqueue_script( 'wpsource-jq-ui-js', WP_SOURCE_FM_PLUGIN_URL . 'includes/ElFinder/jquery/jquery-ui.min.js', [], WP_SOURCE_FM_VERSION, true );
        } else {
            wp_enqueue_script( 'wpsource-jq-ui-js', WP_SOURCE_FM_PLUGIN_URL . 'includes/ElFinder/jquery/jquery-ui-old.min.js', [], WP_SOURCE_FM_VERSION, true );
        }
    }

    public function enqueue_elfinder() {
        wp_enqueue_script( 'wpsource-elfinder-css', WP_SOURCE_FM_PLUGIN_URL . 'includes/ElFinder/css/elfinder.min.css', [], WP_SOURCE_FM_VERSION, true );
        wp_enqueue_script( 'wpsource-elfinder-js', WP_SOURCE_FM_PLUGIN_URL . 'includes/ElFinder/js/elfinder.full.js', [], WP_SOURCE_FM_VERSION );
        wp_enqueue_script( 'wpsource-elfinder-editor', WP_SOURCE_FM_PLUGIN_URL . 'includes/ElFinder/js/extras/editors.default.min.js', [], WP_SOURCE_FM_VERSION );
        wp_enqueue_script( 'wpsource-elfinder-lang', WP_SOURCE_FM_PLUGIN_URL . 'includes/ElFinder/js/i18n/elfinder.LANG.js', [], WP_SOURCE_FM_VERSION );
    }

}
