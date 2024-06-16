<?php
namespace WPInternalLinks\Controllers;

use WPInternalLinks\Utils\SingletonTrait;

/**
 * @method static AddCustomMetaBox get_instance()
 */
class AddCustomMetaBox {

    use SingletonTrait;

    protected function __construct() {
        //  add_action( 'add_meta_boxes', [ $this, 'custom_add_meta_box' ] );
    }

    public function custom_add_meta_box() {
        add_meta_box(
            'custom_meta_box',
            __( 'Suggested Internal Links', 'wpinternallinks' ),
            [ $this, 'custom_meta_box_callback' ],
            [ 'post', 'page' ],
            'normal',
            'high'
        );
    }

    public function custom_meta_box_callback( $post ) {
        echo '<label for="custom_field">Custom field:</label>';
        echo '<input type="text" id="custom_field" name="custom_field" value="' . get_post_meta( $post->ID, 'custom_field', true ) . '" />';
    }
}
