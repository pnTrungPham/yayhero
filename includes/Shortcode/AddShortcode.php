<?php
namespace WPInternalLinks\Shortcode;

use WPInternalLinks\Utils\SingletonTrait;
use WPInternalLinks\Controllers\CreatePostListTableController;

/**
 * @method static AddShortcode get_instance()
 */
class AddShortcode {

    use SingletonTrait;

    /**
     * The Constructor that load the engine classes
     */
    protected function __construct() {
        add_shortcode( 'wp_internal_links_post_list', [ $this, 'custom_post_list_shortcode' ] );
    }

    public function custom_post_list_shortcode() {
        ob_start();
        include WP_INTERNAL_LINKS_PLUGIN_PATH . 'templates/dashboard/table-report.php';
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
