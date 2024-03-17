<?php

namespace WPSource\Enqueue;

use WPSource\Utils\SingletonTrait;

defined( 'ABSPATH' ) || exit;

/**
 * WPSourceViteApp Classes
 */
class WPSourceViteApp {
    use SingletonTrait;

    protected function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'admin_head', [ $this, 'wpsource_register_preload_modules' ] );
        //add_action( 'admin_enqueue_scripts', [ $this, 'wpsource_register_entry' ] );
    }

    public function wpsource_register_preload_modules() {
        echo '<script type="module">
           import RefreshRuntime from "http://localhost:3001/@react-refresh"
           RefreshRuntime.injectIntoGlobalHook(window)
           window.$RefreshReg$ = () => {}
           window.$RefreshSig$ = () => (type) => type
           window.__vite_plugin_react_preamble_installed__ = true
           </script>';
    }

    public function wpsource_register_entry() {
        add_filter(
            'script_loader_tag',
            function ( $tag, $handle, $src ) {
                if ( strpos( $handle, 'module/wpsource/' ) !== false ) {
                    $str  = "type='module'";
                    $str .= WP_SOURCE_FM_IS_DEVELOPMENT ? ' crossorigin' : '';
                    $tag  = '<script ' . $str . ' src="' . $src . '" id="' . $handle . '-js"></script>';
                }
                return $tag;
            },
            10,
            3
        );

        wp_register_script( 'module/wpsource/main.tsx', 'http://localhost:3001/main.tsx', [ 'react', 'react-dom' ], null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
        wp_enqueue_script( 'module/wpsource/main.tsx' );
        wp_localize_script(
            'module/wpsource/main.tsx',
            'wpsourceData',
            [
                'is_rtl'     => is_rtl(),
                'urls'       => [
                    'home_url'  => home_url(),
                    'admin_url' => get_admin_url(),
                ],
                'admin_ajax' => [
                    'url'   => admin_url( 'admin-ajax.php' ),
                    'nonce' => wp_create_nonce( 'yaymail_frontend_nonce' ),
                ],
                'rest_path'  => [
                    'root'  => esc_url_raw( rest_url() ),
                    'nonce' => wp_create_nonce( 'wp_rest' ),
                ],
            ]
        );
    }


}
