<?php

namespace RPFM\FileManagerHandle;

use RPFM\Utils\SingletonTrait;

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
        add_action( 'wp_ajax_rpfm_fm_connector', [ $this, 'rpfm_fm_connector' ] );
    }

    public function rpfm_fm_connector() {
        $opts = [
            'bind'  => [],
            'debug' => false,
            'roots' => [
                [
                    'driver'       => 'LocalFileSystem',
                    'path'         => ABSPATH,
                    'URL'          => site_url(),
                    'trashHash'    => '', // default is empty, when not enable trash
                    'winHashFix'   => DIRECTORY_SEPARATOR !== '/',
                    'uploadDeny'   => [],
                    'uploadAllow'  => [ 'all' ],
                    'uploadOrder'  => [ 'deny', 'allow' ],
                    'disabled'     => [ '' ],
                    'acceptedName' => 'validName',
                    'attributes'   => [], // default is empty
                ],
            ],
        ];

        $connector = new \elFinderConnector( new \elFinder( $opts ) );
        $connector->run();
        wp_die();
    }
}
