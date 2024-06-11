<?php
namespace WPInternalLinks\Controllers;

use WPInternalLinks\Utils\SingletonTrait;


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
            'title'      => 'Title',
            'author'     => 'Author',
            'categories' => 'Categories',
            'tags'       => 'Tags',
            'date'       => 'Date',
        ];
        return $columns;
    }

    public function prepare_items() {
        $query = new \WP_Query(
            [
                'post_type'      => 'post',
                'posts_per_page' => -1,
            ]
        );
        $posts = $query->posts;

        $this->items = $posts;

        $columns               = $this->get_columns();
        $hidden                = [];
        $sortable              = [];
        $this->_column_headers = [ $columns, $hidden, $sortable ];
    }

    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'title':
                return '<a href="' . get_permalink( $item->ID ) . '">' . $item->post_title . '</a>';
            case 'author':
                return get_the_author_meta( 'display_name', $item->post_author );
            case 'categories':
                return get_the_category_list( ', ', '', $item->ID );
            case 'tags':
                return get_the_tag_list( '', ', ', '', $item->ID );
            case 'date':
                return get_the_date( '', $item->ID );
            default:
                return print_r( $item, true ); // Debugging output
        }
    }


}
