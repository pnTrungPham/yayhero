<?php

function wpsource_enqueue_hero_app()
{
    wpsource_register_entry();

    add_action('admin_head', 'wpsource_register_preload_modules');


}


function wpsource_register_entry()
{
    add_filter(
        'script_loader_tag',
        function ($tag, $handle, $src) {
            if (strpos($handle, 'module/wpsource/') !== false) {
                $str  = "type='module'";
                $str .= WP_SOURCE_IS_DEVELOPMENT ? ' crossorigin' : '';
                $tag  = '<script ' . $str . ' src="' . $src . '" id="' . $handle . '-js"></script>';
            }
            return $tag;
        },
        10,
        3
    );

    wp_register_script("module/wpsource/main.tsx", "http://localhost:3000/main.tsx", ['react', 'react-dom'], null, true); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
    wp_enqueue_script("module/wpsource/main.tsx");
    wp_localize_script("module/wpsource/main.tsx", "wpsourceData", [
        'isRtl' => is_rtl(),
        'restUrl' => esc_url_raw(rest_url()),
        'restNonce' => wp_create_nonce('wp_rest'),
    ]);
}

function wpsource_register_preload_modules()
{
    echo '<script type="module">
        import RefreshRuntime from "http://localhost:3000/@react-refresh"
        RefreshRuntime.injectIntoGlobalHook(window)
        window.$RefreshReg$ = () => {}
        window.$RefreshSig$ = () => (type) => type
        window.__vite_plugin_react_preamble_installed__ = true
        </script>';
}
