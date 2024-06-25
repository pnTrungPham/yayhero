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
        add_shortcode( 'wp_internal_links_breadcrumbs', [ $this, 'custom_breadcrumbs_shortcode' ] );
    }

    public function custom_breadcrumbs_shortcode() {
        return $this->custom_breadcrumbs();
    }

    public function custom_breadcrumbs() {
        $home_text = 'Home';
        $separator = ' &raquo; ';
        $home_link = home_url( '/' );

        $breadcrumb = '<a href="' . $home_link . '">' . $home_text . '</a>';

        if ( is_home() || is_front_page() ) {
            return $breadcrumb;
        }

        if ( is_category() ) {
            $category    = get_queried_object();
            $breadcrumb .= $separator . single_cat_title( '', false );
        } elseif ( is_single() ) {
            $category = get_the_category();
            if ( $category ) {
                $breadcrumb .= $separator . '<a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->name . '</a>';
            }
            $breadcrumb .= $separator . get_the_title();
        } elseif ( is_page() && ! is_front_page() ) {
            global $post;
            if ( $post->post_parent ) {
                $parent_id = $post->post_parent;
                $crumbs    = [];
                while ( $parent_id ) {
                    $page      = get_page( $parent_id );
                    $crumbs[]  = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $crumbs = array_reverse( $crumbs );
                foreach ( $crumbs as $crumb ) {
                    $breadcrumb .= $separator . $crumb;
                }
            }
            $breadcrumb .= $separator . get_the_title();
        } elseif ( is_tag() ) {
            $breadcrumb .= $separator . single_tag_title( '', false );
        } elseif ( is_author() ) {
            $breadcrumb .= $separator . get_the_author();
        } elseif ( is_search() ) {
            $breadcrumb .= $separator . 'Search results for: ' . get_search_query();
        } elseif ( is_404() ) {
            $breadcrumb .= $separator . 'Error 404';
        }

        return '<div class="custom-breadcrumbs">' . $breadcrumb . '</div>';
    }

    public function custom_post_list_shortcode() {
        ob_start();
        include WP_INTERNAL_LINKS_PLUGIN_PATH . 'templates/dashboard/table-report.php';
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
