<?php
defined( 'ABSPATH' ) || exit;

use WPInternalLinks\Controllers\CreatePostListTableController;

$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : '';
if ( ! empty( $nonce ) && ! wp_verify_nonce( $nonce, 'wp-internal-links-nonce' ) ) {
    wp_die( 'Security check' );
}

$post_list_table = CreatePostListTableController::get_instance();

$post_list_table->prepare_items();

$all_count    = $post_list_table->get_post_count_by_type();
$page_count   = $post_list_table->get_post_count_by_type( 'page' );
$post_count   = $post_list_table->get_post_count_by_type( 'post' );
$other_count  = $post_list_table->get_post_count_by_type( '' ); // Other post type
$orphan_count = $post_list_table->get_post_count_by_type( [ 'page' ], true );
?>

<div class="wrap">
    <ul class="subsubsub" style="margin-bottom:10px">
        <?php
        $get_post_type = filter_input( INPUT_GET, 'get_post_type', FILTER_SANITIZE_STRING ) ?? 'all';
        $only_orphan   = filter_input( INPUT_GET, 'only_orphan', FILTER_SANITIZE_STRING ) ?? '';

        $links = [
            'all'    => [ esc_html__( 'All', 'wpinternallinks' ), $all_count ],
            'page'   => [ esc_html__( 'Only Page', 'wpinternallinks' ), $page_count ],
            'post'   => [ esc_html__( 'Only Post', 'wpinternallinks' ), $post_count ],
            'other'  => [ esc_html__( 'Other Post Type', 'wpinternallinks' ), $other_count ],
            'orphan' => [ esc_html__( 'Only Orphan Page', 'wpinternallinks' ), $orphan_count ],
        ];

        foreach ( $links as $key => $label_count ) {
            $class = ( $get_post_type === $key || ( $only_orphan && 'orphan' === $key ) ) ? 'class="current"' : '';
            $href  = add_query_arg(
                array_merge(
                    $_REQUEST,
                    [
                        'get_post_type' => 'orphan' !== $key ? $key : '',
                        'only_orphan'   => 'orphan' === $key ? '1' : '',
                        'page'          => 'wp_internal_links_dashboard',
                    ]
                )
            );
            echo '<li><a href="' . esc_url( $href ) . '" ' . wp_kses_post( $class ) . '>' . esc_attr( $label_count[0] ) . ' <span class="count">(' . esc_attr( $label_count[1] ) . ')</span></a> | </li>';
        }
        ?>
    </ul>
    <div class="clear"></div>
    <form method="get">
        <input type="hidden" name="page" value="wp_internal_links_dashboard">
        <input type="hidden" name="nonce" value="<?php echo wp_kses_post( wp_create_nonce( 'wp-internal-links-nonce' ) ); ?>">
        <?php $post_list_table->search_box( 'Search', 'search_id' ); ?>
        <select name="category" id="category">
            <option value=""><?php esc_html_e( 'Select Category', 'wpinternallinks' ); ?></option>
            <?php
            $selected_category = filter_input( INPUT_GET, 'category', FILTER_SANITIZE_STRING ) ?? '';
            $categories        = get_categories();

            foreach ( $categories as $cate_item ) {
                $selected = $selected_category === $cate_item->term_id ? 'selected' : '';
                echo '<option value="' . esc_attr( $cate_item->term_id ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $cate_item->name ) . '</option>';
            }

            ?>
        </select>
        <input type="submit" value="Filter" class="button">
    </form>
    <div class="clear"></div>
    <div>
        <?php $post_list_table->display(); ?>
    </div>
</div>
