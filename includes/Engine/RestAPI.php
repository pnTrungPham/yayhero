<?php
namespace WPSource\Engine;

use WPSource\Utils\SingletonTrait;
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
        add_action( 'rest_api_init', [ $this, 'add_wpsource_endpoints' ] );
    }

    /**
     * Add YayMail Endpoints
     */
    public function add_wpsource_endpoints() {

    }
}
