<?php
namespace WPInternalLinks;

use WPInternalLinks\Utils\SingletonTrait;
use WPInternalLinks\Controllers\AdminMenuController;
use WPInternalLinks\Enqueue\AdminEnqueue;
use WPInternalLinks\Shortcode\AddShortcode;

/**
 * WPInternalLinks Plugin Initializer
 *
 * @method static Initialize get_instance()
 */
class Initialize {

    use SingletonTrait;

    /**
     * The Constructor that load the engine classes
     */
    protected function __construct() {
        add_action( 'init', [ $this, 'wp_internal_links_init' ] );
    }

    public static function wp_internal_links_init() {
        AdminEnqueue::get_instance();
        Ajax::get_instance();
        AddShortcode::get_instance();
        AdminMenuController::get_instance();
    }
}
