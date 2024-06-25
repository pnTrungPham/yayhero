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

    protected $total_items;
    protected $per_page = 10; // Number of items per page

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
            'title'                      => 'Title',
            'categories'                 => 'Categories',
            'inbound_links'              => $this->get_inbound_links_title(),
            'outbound_links'             => esc_html__( 'Outbound', 'wpinternallinks' ),
            'inbound_links_in_category'  => $this->get_inbound_links_within_category_title(),
            'outbound_links_in_category' => 'Outbound',
            'link_back_to_category'      => $this->get_link_back_category_title(),
        ];
        return $columns;
    }

    public static function get_link_back_category_title() {
        ob_start();
        ?>
            <div class="wpil-link-back-category-title-title">
                <img width="50" src="<?php echo esc_url( WP_INTERNAL_LINKS_PLUGIN_URL . 'assets/admin/images/logo-back-parent.png' ); ?>" alt="WP Internal Links">
                <p class="wpil-text-label"><strong><?php esc_html_e( 'Internal Links', 'wpinternallinks' ); ?></strong></p>
                <p class="wpil-text-des"><strong><?php esc_html_e( '[Back to Parent]', 'wpinternallinks' ); ?></strong></p>
                <p><?php esc_html_e( 'Link back to Category', 'wpinternallinks' ); ?></p>
            </div>
        <?php
        return ob_get_clean();
    }


    public static function get_inbound_links_within_category_title() {
        ob_start();
        ?>
            <div class="wpil-inbound-links-within-category-title">
                <img width="50" src="<?php echo esc_url( WP_INTERNAL_LINKS_PLUGIN_URL . 'assets/admin/images/logo-within-cat.png' ); ?>" alt="WP Internal Links">
                <p class="wpil-text-label"><strong><?php esc_html_e( 'Internal Links', 'wpinternallinks' ); ?></strong></p>
                <p class="wpil-text-des"><strong><?php esc_html_e( '[Within the Category]', 'wpinternallinks' ); ?></strong></p>
                <p><?php esc_html_e( 'Inbound', 'wpinternallinks' ); ?></p>
            </div>
        <?php
        return ob_get_clean();
    }

    public static function get_inbound_links_title() {
        ob_start();
        ?>
            <div class="wpil-inbound-links-title">
                <img width="50" src="<?php echo esc_url( WP_INTERNAL_LINKS_PLUGIN_URL . 'assets/admin/images/logo-entrire.png' ); ?>" alt="WP Internal Links">
                <p class="wpil-text-label"><strong><?php esc_html_e( 'Internal Links', 'wpinternallinks' ); ?></strong></p>
                <p class="wpil-text-des"><strong><?php esc_html_e( '[Entire WebSite]', 'wpinternallinks' ); ?></strong></p>
                <p><?php esc_html_e( 'Inbound', 'wpinternallinks' ); ?></p>
            </div>
        <?php
        return ob_get_clean();
    }

    public function get_sortable_columns() {
        $sortable_columns = [
            'title'                      => [ 'title', true ],
            'inbound_links'              => [ 'inbound_links', false ],
            'outbound_links'             => [ 'outbound_links', false ],
            'inbound_links_in_category'  => [ 'inbound_links_in_category', false ],
            'outbound_links_in_category' => [ 'outbound_links_in_category', false ],
            'link_back_to_category'      => [ 'link_back_to_category', false ],
        ];
        return $sortable_columns;
    }

    public function prepare_items() {
        $post_type    = filter_input( INPUT_GET, 'get_post_type', FILTER_SANITIZE_STRING ) ?? '';
        $category     = filter_input( INPUT_GET, 'category', FILTER_SANITIZE_STRING ) ?? '';
        $search_value = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING ) ?? '';
        $only_orphan  = filter_input( INPUT_GET, 'only_orphan', FILTER_SANITIZE_STRING ) === '1';
        $paged        = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT ) ?? 1;

        $args = [
            'post_type'      => [ 'post', 'page' ],
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];

        if ( ! empty( $post_type ) && in_array( $post_type, [ 'post', 'page' ] ) ) {
            $args['post_type'] = $post_type;
        }

        if ( ! empty( $category ) ) {
            $args['cat'] = $category;
        }

        if ( ! empty( $search_value ) ) {
            $args['s'] = $search_value;
            add_filter( 'posts_where', [ $this, 'title_filter' ], 10, 2 );
        }

        $query = new \WP_Query( $args );
        $posts = [];

        if ( ! empty( $search_value ) ) {
            remove_filter( 'posts_where', [ $this, 'title_filter' ], 10 );
        }

        foreach ( $query->posts as $post ) {
            $content = $post->post_content;
            if ( InternalLinksController::has_internal_links( $content ) ) {
                $posts[] = $post;
            }
        }

        // Fillter orphan posts outbound internal links
        if ( $only_orphan ) {
            $posts = array_filter(
                $posts,
                function( $post ) {
                    $inbound_links = InternalLinksController::get_inbound_internal_links( $post->ID );
                    return empty( $inbound_links );
                }
            );
        }

        // Handle sorting
        usort( $posts, [ $this, 'sort_items' ] );

        // Set pagination parameters
        $total_items       = count( $posts );
        $this->total_items = $total_items;
        $this->set_pagination_args(
            [
                'total_items' => $total_items,
                'per_page'    => $this->per_page,
            ]
        );

        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $this->per_page;
        $this->items  = array_slice( $posts, $offset, $this->per_page );

        $columns               = $this->get_columns();
        $hidden                = [];
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = [ $columns, $hidden, $sortable ];
    }

    public function title_filter( $where, $wp_query ) {
        global $wpdb;
        $search_value = $wp_query->get( 's' );
        if ( $search_value ) {
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_value ) ) . '%\'';
        }
        return $where;
    }

    protected function column_title( $item ) {
        $type  = '<span class="wpil-post-type"> [' . get_post_type( $item->ID ) . ']</span>';
        $title = '<a class="row-title" href="' . get_edit_post_link( $item->ID ) . '">' . $item->post_title . $type . '</a>';

        $edit_link = get_edit_post_link( $item->ID );
        $permalink = get_permalink( $item->ID );

        $actions = [
            'find_inbound_link_opportunities' => sprintf( '<a href="%s">%s</a>', $edit_link, __( 'Find Inbound Link Opportunities', 'wpinternallinks' ) ),
            'copy_link'                       => sprintf( '<a class="wpil-copy-link" data-post-url="%s">%s</a>', $permalink, __( 'Copy Permalink', 'wpinternallinks' ) ),
        ];

        return sprintf( '%1$s %2$s', $title, $this->row_actions( $actions ) );
    }

    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'categories':
                return $this->get_hierarchical_categories( $item->ID );
            case 'inbound_links':
                $count = count( InternalLinksController::get_inbound_internal_links( $item->ID ) );
                $class = $count > 0 ? ' bg-green' : ' bg-gray';
                return '<a href="#" class="wpil-count-link inbound-links-count' . $class . '" data-type="inbound" data-post-id="' . $item->ID . '">' . $count . '</a>';
            case 'outbound_links':
                $count = count( InternalLinksController::get_outbound_internal_links( $item->ID ) );
                $class = $count > 0 ? ' bg-green' : ' bg-gray';
                return '<a href="#" class="wpil-count-link outbound-links-count' . $class . '"  data-type="outbound" data-post-id="' . $item->ID . '">' . $count . '</a>';
            case 'inbound_links_in_category':
                $count = count( InternalLinksController::get_inbound_internal_links_in_category( $item->ID ) );
                $class = $count > 0 ? ' bg-green' : ' bg-gray';
                return '<a href="#" class="wpil-count-link inbound-links-in-category-count' . $class . '"  data-type="inbound_category" data-post-id="' . $item->ID . '">' . $count . '</a>';
            case 'outbound_links_in_category':
                $count = count( InternalLinksController::get_outbound_internal_links_in_category( $item->ID ) );
                $class = $count > 0 ? ' bg-green' : ' bg-gray';
                return '<a href="#" class="wpil-count-link outbound-links-in-category-count' . $class . '"  data-type="outbound_category" data-post-id="' . $item->ID . '">' . $count . '</a>';
            case 'link_back_to_category':
                return self::get_category_link( $item->ID );
            default:
                return print_r( $item, true );
        }
    }

    public static function get_category_link( $post_id ) {
        $categories = get_the_category( $post_id );

        if ( ! empty( $categories ) ) {
            $main_category = $categories[0];
            $category_link = get_category_link( $main_category->term_id );

            $content    = get_post_field( 'post_content', $post_id );
            $link       = 'href="' . esc_url( $category_link ) . '"';
            $link_count = substr_count( $content, $link );
            $class      = $link_count > 0 ? ' bg-green' : ' bg-gray';

            return '<a  class="wpil-count-link' . $class . '"  href="' . esc_url( $category_link ) . '">' . __( 'View Category', 'wpinternallinks' ) . '</a>';
        }

        return '';
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
                $b_count = count( InternalLinksController::get_outbound_internal_links( $b->ID ) );
                $result  = $a_count - $b_count;
                break;
            default:
                $result = 0;
        }

        return ( 'asc' === $order ) ? $result : -$result;
    }

    public function get_post_count_by_type( $post_type = '', $only_orphan = false ) {
        $args = [
            'post_type'      => $post_type ? $post_type : [ 'post', 'page' ],
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];

        if ( $only_orphan ) {
            $args['meta_query'] = [
                [
                    'key'     => '_wp_page_template',
                    'value'   => 'default',
                    'compare' => 'NOT EXISTS',
                ],
            ];
        }

        $query                     = new \WP_Query( $args );
        $posts_with_internal_links = array_filter(
            $query->posts,
            function( $post ) {
                return InternalLinksController::has_internal_links( $post->post_content );
            }
        );

        return count( $posts_with_internal_links );
    }

    private function get_hierarchical_categories( $post_id ) {
        $taxonomy = get_option( 'wpinternallinks_taxonomy', 'category' );

        $terms = get_the_terms( $post_id, $taxonomy );
        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            return '';
        }

        $terms_hierarchical = [];
        foreach ( $terms as $term ) {
            $ancestors         = get_ancestors( $term->term_id, $taxonomy );
            $ancestors         = array_reverse( $ancestors );
            $ancestors[]       = $term->term_id;
            $hierarchical_name = '';
            foreach ( $ancestors as $ancestor_id ) {
                $ancestor           = get_term( $ancestor_id, $taxonomy );
                $hierarchical_name .= $ancestor->name . ' / ';
            }
            $hierarchical_name    = rtrim( $hierarchical_name, ' / ' );
            $terms_hierarchical[] = $hierarchical_name;
        }

        return implode( ', ', $terms_hierarchical );
    }
}
