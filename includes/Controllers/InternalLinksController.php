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
                if ( preg_match_all( '/<a\s[^>]*href=["\']' . preg_quote( get_permalink( $post_id ), '/' ) . '["\'][^>]*>(.*?)<\/a>/i', $post->post_content, $matches ) ) {
                    foreach ( $matches[1] as $anchor_text ) {
                        $links[] = [
                            'ID'          => $post->ID,
                            'title'       => $post->post_title,
                            'type'        => $post->post_type,
                            'categories'  => get_the_category_list( ', ', '', $post->ID ),
                            'anchor_text' => $anchor_text,
                        ];
                    }
                }
            }
        }

        return $links;
    }

    public static function get_outbound_internal_links( $post_id ) {
        $home_url = home_url();
        $post     = get_post( $post_id );
        $content  = $post->post_content;
        $links    = [];

        if ( preg_match_all( '/<a\s[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/i', $content, $matches, PREG_SET_ORDER ) ) {
            foreach ( $matches as $match ) {
                $url         = $match[1];
                $anchor_text = $match[2];
                if ( strpos( $url, $home_url ) === 0 ) {
                    $linked_post_id = url_to_postid( $url );
                    if ( $linked_post_id && $linked_post_id !== $post_id ) {
                        $linked_post = get_post( $linked_post_id );
                        $links[]     = [
                            'ID'          => $linked_post->ID,
                            'title'       => $linked_post->post_title,
                            'type'        => $linked_post->post_type,
                            'categories'  => get_the_category_list( ', ', '', $linked_post->ID ),
                            'anchor_text' => $anchor_text,
                        ];
                    }
                }
            }
        }

        return $links;
    }
}
