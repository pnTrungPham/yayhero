<?php
namespace WPInternalLinks\Controllers;

use WPInternalLinks\Utils\SingletonTrait;

/**
 *
 * @method static MetaBoxMainCategory get_instance()
 */
class MetaBoxMainCategory {

    use SingletonTrait;

    protected function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_main_category_meta_box' ] );
        add_action( 'save_post', [ $this, 'save_main_category_meta_box_data' ] );

        add_action( 'category_edit_form_fields', [ $this, 'add_custom_field_to_category_edit_form' ] );
        add_action( 'edited_category', [ $this, 'save_custom_field_meta' ] );
    }

    public function save_custom_field_meta( $term_id ) {
        if ( isset( $_POST['custom_select_field'] ) ) {
            update_term_meta( $term_id, 'custom_select_field', sanitize_text_field( $_POST['custom_select_field'] ) );
        }
    }

    public function add_custom_field_to_category_edit_form( $term ) {
        $selected_value = get_term_meta( $term->term_id, 'custom_select_field', true );

        $args  = [
            'category'    => $term->term_id,
            'post_status' => 'publish',
            'numberposts' => -1,
        ];
        $posts = get_posts( $args );

        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="custom_select_field"> <?php esc_html_e( 'Main Category Post', 'wpinternallinks' ); ?> </label></th>
            <td>
                <select name="custom_select_field" id="custom_select_field" class="postform">
                    <?php
                    foreach ( $posts as $post ) {
                        echo '<option value="' . esc_attr( $post->ID ) . '"' . selected( $selected_value, $post->ID, false ) . '>' . esc_html( $post->post_title ) . '</option>';
                    }
                    ?>
                </select>
                <p class="description"><?php esc_html_e( 'Select the main post for this category.', 'wpinternallinks' ); ?> </p>
            </td>
        </tr>
        <?php
    }

    public function add_main_category_meta_box() {
        add_meta_box(
            'main_category_meta_box',
            'Main Category',
            [ $this, 'render_main_category_meta_box' ],
            [ 'post' ],
            'normal',
            'low'
        );
    }

    public function render_main_category_meta_box( $post ) {
        wp_nonce_field( 'main_category_nonce', 'main_category_nonce' );
        $main_category = get_post_meta( $post->ID, '_main_category', true );
        $categories    = get_the_category( $post->ID );

        if ( ! empty( $categories ) ) {
            echo '<select name="main_category" id="main_category">';
            echo '<option value="">Select Main Category</option>';
            foreach ( $categories as $category ) {
                echo '<option value="' . esc_attr( $category->term_id ) . '"' . selected( $main_category, $category->term_id, false ) . '>' . esc_html( $category->name ) . '</option>';
            }
            echo '</select>';
        } else {
            echo 'This post has no categories assigned.';
        }
    }

    public function save_main_category_meta_box_data( $post_id ) {
        if ( ! isset( $_POST['main_category_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['main_category_nonce'], 'main_category_nonce' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        $main_category = sanitize_text_field( $_POST['main_category'] );
        update_post_meta( $post_id, '_main_category', $main_category );
    }


}

