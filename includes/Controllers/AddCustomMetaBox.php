<?php
namespace WPInternalLinks\Controllers;

use WPInternalLinks\Utils\SingletonTrait;

/**
 *
 * @method static AddCustomMetaBox get_instance()
 */
class AddCustomMetaBox {

    use SingletonTrait;

    protected function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'custom_add_meta_box' ] );
    }

    public function custom_add_meta_box() {
        add_meta_box(
            'internal-link-suggestions',
            __( 'Suggested Internal Links', 'wpinternallinks' ),
            [ $this, 'display_internal_link_suggestions_meta_box' ],
            [ 'post', 'page' ],
            'normal',
            'high'
        );
    }

    public function display_internal_link_suggestions_meta_box( $post ) {
        // Get internal link suggestions
        $suggestions = $this->get_internal_link_suggestions( $post->ID );

        // Output the suggestions
        if ( ! empty( $suggestions ) ) {
            ob_start();
            include WP_INTERNAL_LINKS_PLUGIN_PATH . 'templates/meta-box/suggestion-table.php';
            $html = ob_get_contents();
            ob_end_clean();
            wp_ilink_kses_post_e( $html );
        } else {
            echo 'No internal link suggestions available.';
        }

    }

    public function get_internal_link_suggestions( $post_id ) {
        $suggestions = [];

        $post_content = get_post_field( 'post_content', $post_id );

        $keywords = $this->extract_keywords_tfidf( $post_content );

        foreach ( $keywords as $keyword => $weight ) {
            $related_posts = get_posts(
                [
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => 5,
                    'post__not_in'   => [ $post_id ],
                    's'              => $keyword,
                ]
            );

            foreach ( $related_posts as $related_post ) {
                $title = get_the_title( $related_post->ID );
                $url   = get_permalink( $related_post->ID );

                $post_content = $this->replace_keyword_with_link( $post_content, $keyword, $title, $url );

                $suggestions[] = [
                    'title'  => $title,
                    'url'    => $url,
                    'weight' => $weight,
                ];
            }
        }

        wp_update_post(
            [
                'ID'           => $post_id,
                'post_content' => $post_content,
            ]
        );

        usort(
            $suggestions,
            function( $a, $b ) {
                return $b['weight'] <=> $a['weight'];
            }
        );

        $suggestions = array_map( 'unserialize', array_unique( array_map( 'serialize', $suggestions ) ) );

        return apply_filters( 'internal_link_suggestions', $suggestions, $post_id );
    }

    private function extract_keywords_tfidf( $content ) {
        // Implement your TF-IDF keyword extraction logic here

        // Dummy implementation for demonstration
        $keywords = [];
        $words    = array_unique( explode( ' ', strip_tags( $content ) ) );
        foreach ( $words as $word ) {
            $keywords[ $word ] = 1; // Dummy weight, replace with actual TF-IDF score
        }

        return $keywords;
    }

    private function replace_keyword_with_link( $content, $keyword, $title, $url ) {
        $content = preg_replace( "/(?<!['\"])(?<!href=)['\"]\b($keyword)\b['\"](?!['\"])/i", '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '">$1</a>', $content );

        return $content;
    }


    public function highlight_places_in_content( $content, $suggestions ) {
        foreach ( $suggestions as $suggestion ) {
            $title = $suggestion['title'];
            $url   = $suggestion['url'];

            $content = preg_replace( "/\b($title)\b/i", '<span class="highlighted-place"><a href="' . esc_url( $url ) . '">$1</a></span>', $content );
        }

        return $content;
    }
}
