<?php
namespace WPSource;

use WPSource\Utils\SingletonTrait;

/**
 * WPSource Plugin Initializer
 *
 * @method static Initialize get_instance()
 */
class Initialize {

    use SingletonTrait;

    /**
     * The Constructor that load the engine classes
     */
    protected function __construct() {
        add_action( 'init', [ $this, 'wpsource_init' ] );
    }

    public static function wpsource_init() {
        \WPSource\Enqueue\WPSourceViteApp::get_instance();
        \WPSource\Engine\RestAPI::get_instance();
        \WPSource\FileManagerHandle\AdminMenuHandle::get_instance();
    }
}
