<?php

namespace WPSource\FileManagerHandle;

use WPSource\Utils\SingletonTrait;

defined( 'ABSPATH' ) || exit;

/**
 * Connector Classes
 */
class Connector {
    use SingletonTrait;



    protected function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'wp_ajax_fs_connector', [ $this, 'fsConnector' ] );
    }

    public function wpsource_add_admin_page() {

    }

}
