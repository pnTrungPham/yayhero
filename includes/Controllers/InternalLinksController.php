<?php
namespace WPInternalLinks\Controllers;

use WPInternalLinks\Utils\SingletonTrait;

/**
 *
 * @method static InternalLinksController get_instance()
 */
class InternalLinksController {

    use SingletonTrait;

    public static function has_internal_links( $content ) {
        $home_url = home_url();
        return preg_match( '/<a\s[^>]*href=["\']' . preg_quote( $home_url, '/' ) . '[^"\']*["\'][^>]*>/i', $content );
    }

    public static function get_inbound_internal_links( $post_id ) {
        $args = [
            'post_type'      => [ 'post', 'page' ],
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            's'              => get_permalink( $post_id ),
        ];

        $query = new \WP_Query( $args );
        $links = [];

        foreach ( $query->posts as $post ) {
            if ( $post->ID !== $post_id && stripos( $post->post_content, get_permalink( $post_id ) ) !== false ) {
                $links[] = '<a href="' . get_edit_post_link( $post->ID ) . '">' . $post->post_title . '</a>';
            }
        }

        return implode( ', ', $links );
    }

    public static function get_outbound_internal_links( $post ) {
        $home_url = home_url();
        $content  = $post->post_content;
        $links    = [];

        if ( preg_match_all( '/<a\s[^>]*href=["\']([^"\']+)["\'][^>]*>/i', $content, $matches ) ) {
            foreach ( $matches[1] as $url ) {
                if ( strpos( $url, $home_url ) === 0 ) {
                    $post_id = url_to_postid( $url );
                    if ( $post_id && $post_id !== $post->ID ) {
                        $links[] = '<a href="' . get_edit_post_link( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
                    }
                }
            }
        }

        return implode( ', ', $links );
    }
}
