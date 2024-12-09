<?php
namespace RPFM;

use RPFM\Utils\SingletonTrait;

/**
 * RPFM Plugin Initializer
 *
 * @method static Initialize get_instance()
 */
class Initialize {

    use SingletonTrait;

    /**
     * The Constructor that load the engine classes
     */
    protected function __construct() {
        add_action( 'init', [ $this, 'rpfm_init' ] );
    }

    public static function rpfm_init() {
        //\RPFM\Controllers\SettingController::get_instance();
        \RPFM\Enqueue\Admin::get_instance();
        \RPFM\Enqueue\RPFMViteApp::get_instance();
        \RPFM\Engine\RestAPI::get_instance();
        \RPFM\FileManagerHandle\AdminMenuHandle::get_instance();
        \RPFM\FileManagerHandle\Connector::get_instance();
    }
}
