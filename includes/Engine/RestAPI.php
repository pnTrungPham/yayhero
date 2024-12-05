<?php
namespace RPFM\Engine;

use RPFM\Utils\SingletonTrait;
/**
 * YayMail Rest API
 */
class RestAPI {
    use SingletonTrait;

    /**
     * Hooks Initialization
     *
     * @return void
     */
    protected function __construct() {
        add_action( 'rest_api_init', [ $this, 'add_rpfm_endpoints' ] );
    }

    /**
     * Add YayMail Endpoints
     */
    public function add_rpfm_endpoints() {

    }
}
