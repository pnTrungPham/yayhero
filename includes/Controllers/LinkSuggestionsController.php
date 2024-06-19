<?php
namespace WPInternalLinks\Controllers;

use WPInternalLinks\Utils\SingletonTrait;

/**
 *
 * @method static LinkSuggestionsController get_instance()
 */
class LinkSuggestionsController {

    use SingletonTrait;


    public static function get_post_suggestions( $post_id, $target_id = null, $keyword = null, $count = 5 ) {
        $post = get_post( $post_id );
        if ( ! $post ) {
            return [];
        }

        $ignore_words = [ 'the', 'is', 'at', 'which', 'on', 'and' ];

        if ( $target_id ) {
            $internal_links = self::get_linked_post_id( $target_id );
        } else {
            $internal_links = self::get_outbound_links( $post_id );
        }

        $used_posts = [];
        foreach ( $internal_links as $link ) {
            if ( ! empty( $link->ID ) ) {
                $used_posts[] = $link->ID;
            }
        }

        $words_to_posts = self::get_title_words( $keyword );

        $suggestions = [];
        foreach ( $words_to_posts as $word => $posts ) {
            if ( in_array( $word, $ignore_words ) ) {
                continue;
            }

            foreach ( $posts as $p ) {
                if ( in_array( $p->ID, $used_posts ) ) {
                    continue;
                }

                if ( ! isset( $suggestions[ $p->ID ] ) ) {
                    $suggestions[ $p->ID ] = [
                        'post'  => $p,
                        'score' => 0,
                        'words' => [],
                    ];
                }

                $suggestions[ $p->ID ]['words'][] = $word;
                $suggestions[ $p->ID ]['score']  += 1;
            }
        }

        usort(
            $suggestions,
            function ( $a, $b ) {
                return $b['score'] - $a['score'];
            }
        );

        return array_slice( $suggestions, 0, $count );
    }

    private static function get_linked_post_id( $target_id ) {
        global $wpdb;
        $linked_posts = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' AND ID IN (SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = 'linked_post_id' AND post_id = %d)",
                $target_id
            )
        );
        return $linked_posts;
    }

    private static function get_outbound_links( $post_id ) {
        global $wpdb;
        $outbound_links = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' AND ID IN (SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = 'outbound_link_id' AND post_id = %d)",
                $post_id
            )
        );
        return $outbound_links;
    }

    private static function get_title_words( $keyword = null ) {
        global $wpdb;
        $sql = "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish'";
        if ( $keyword ) {
            $sql .= $wpdb->prepare( ' AND post_title LIKE %s', '%' . $wpdb->esc_like( $keyword ) . '%' );
        }
        $posts = $wpdb->get_results( $sql );

        $words_to_posts = [];
        foreach ( $posts as $post ) {
            $words = explode( ' ', strtolower( $post->post_title ) );
            foreach ( $words as $word ) {
                if ( ! isset( $words_to_posts[ $word ] ) ) {
                    $words_to_posts[ $word ] = [];
                }
                $words_to_posts[ $word ][] = $post;
            }
        }

        return $words_to_posts;
    }
}

