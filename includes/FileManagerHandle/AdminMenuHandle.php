<?php

namespace RPFM\FileManagerHandle;

use RPFM\Utils\SingletonTrait;

defined( 'ABSPATH' ) || exit;

/**
 * AdminMenuHandle Classes
 */
class AdminMenuHandle {
    use SingletonTrait;


    private $hook_suffix = [];

    protected function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'admin_menu', [ $this, 'rpfm_add_admin_page' ] );
    }

    public function rpfm_add_admin_page() {

        $icon           = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZD0iTTEwLDRINEMyLjg5LDQgMiw0Ljg5IDIsNlYxOEEyLDIgMCAwLDAgNCwyMEgyMEEyLDIgMCAwLDAgMjIsMThWOEMyMiw2Ljg5IDIxLjEsNiAyMCw2SDEyTDEwLDRaIiBmaWxsPSIjYTdhYWFkIi8+PC9zdmc+';
        $display_suffix = add_menu_page(
            __( 'File Manager', 'rpfm' ),
            __( 'File Manager', 'rpfm' ),
            'manage_options',
            'rpfm/rpfm-admin.php',
            [ $this, 'rpfm_render_file_manager' ],
            $icon,
            30
        );

        // $settings_suffix = add_submenu_page(
        //     'rpfm/rpfm-admin.php',
        //     'Settings',
        //     'Settings',
        //     'manage_options',
        //     'rpfm-settings',
        //     [ $this, 'settings_page' ]
        // );

        $this->hook_suffix = [ $display_suffix ];
    }

    public function rpfm_render_file_manager() {
        include RPFM_PLUGIN_PATH . 'views/Admin/file-manager.php';
    }

    public function settings_page() {
        include RPFM_PLUGIN_PATH . 'views/Admin/setting.php';
    }

}
