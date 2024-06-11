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
        $post_list_table = CreatePostListTableController::get_instance();

        $post_list_table->prepare_items();

        echo '<div class="wrap"><h1 class="wp-heading-inline">All Posts </h1>';
        $post_list_table->display();
        echo '</div>';
        return ob_get_clean();
    }
}
