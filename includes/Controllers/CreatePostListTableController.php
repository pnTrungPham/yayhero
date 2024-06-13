<?php
namespace WPInternalLinks\Controllers;

use WPInternalLinks\Utils\SingletonTrait;
use WPInternalLinks\Controllers\InternalLinksController;

// Include the WP_List_Table class
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * @method static CreatePostListTableController get_instance()
 */
class CreatePostListTableController extends \WP_List_Table {

    use SingletonTrait;

    /**
     * The Constructor that load the engine classes
     */
    protected function __construct() {
        parent::__construct(
            [
                'singular' => 'post',
                'plural'   => 'posts',
                'ajax'     => false,
            ]
        );
    }

    public function get_columns() {
        $columns = [
            'title'          => 'Title',
            'categories'     => 'Categories',
            'type'           => 'Type',
            'inbound_links'  => 'Inbound Internal Links',
            'outbound_links' => 'Outbound Internal Links',
        ];
        return $columns;
    }

    public function get_sortable_columns() {
        $sortable_columns = [
            'title'          => [ 'title', true ],
            'inbound_links'  => [ 'inbound_links', false ],
            'outbound_links' => [ 'outbound_links', false ],
        ];
        return $sortable_columns;
    }

    public function prepare_items() {
        // Query posts and pages that contain internal links
        $args = [
            'post_type'      => [ 'post', 'page' ],
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];

        $query = new \WP_Query( $args );
        $posts = [];

        foreach ( $query->posts as $post ) {
            $content = $post->post_content;
            if ( InternalLinksController::has_internal_links( $content ) ) {
                $posts[] = $post;
            }
        }

        // Handle sorting
        usort( $posts, [ $this, 'sort_items' ] );

        $this->items = $posts;

        $columns               = $this->get_columns();
        $hidden                = [];
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = [ $columns, $hidden, $sortable ];
    }

    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'title':
                return '<a href="' . get_edit_post_link( $item->ID ) . '">' . $item->post_title . '</a>';
            case 'categories':
                return get_the_category_list( ', ', '', $item->ID );
            case 'type':
                return ucfirst( $item->post_type );
            case 'inbound_links':
                $count = count( InternalLinksController::get_inbound_internal_links( $item->ID ) );
                return '<a href="#" class="inbound-links-count" data-post-id="' . $item->ID . '">' . $count . '</a>';
            case 'outbound_links':
                $count = count( InternalLinksController::get_outbound_internal_links( $item->ID ) );
                return '<a href="#" class="outbound-links-count" data-post-id="' . $item->ID . '">' . $count . '</a>';
            default:
                return print_r( $item, true );
        }
    }

    private function sort_items( $a, $b ) {
        $orderby = filter_input( INPUT_GET, 'orderby', FILTER_SANITIZE_STRING ) ?? 'title';
        $order   = filter_input( INPUT_GET, 'order', FILTER_SANITIZE_STRING ) ?? 'asc';

        switch ( $orderby ) {
            case 'title':
                $result = strcmp( $a->post_title, $b->post_title );
                break;
            case 'inbound_links':
                $a_count = count( InternalLinksController::get_inbound_internal_links( $a->ID ) );
                $b_count = count( InternalLinksController::get_inbound_internal_links( $b->ID ) );
                $result  = $a_count - $b_count;
                break;
            case 'outbound_links':
                $a_count = count( InternalLinksController::get_outbound_internal_links( $a->ID ) );
                $b_count = count( InternalLinksController::get_outbound_internal_links( $a->ID ) );
                $result  = $a_count - $b_count;
                break;
            default:
                $result = 0;
        }

        return ( 'asc' === $order ) ? $result : -$result;
    }
}
