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
                        $linked_post     = get_post( $linked_post_id );
                        $post_categories = get_the_category( $linked_post_id );
                        $category_ids    = array_map(
                            function( $cat ) {
                                return $cat->term_id;
                            },
                            $post_categories
                        );
                        $links[]         = [
                            'ID'          => $linked_post->ID,
                            'title'       => $linked_post->post_title,
                            'type'        => $linked_post->post_type,
                            'categories'  => $category_ids,
                            'anchor_text' => $anchor_text,
                        ];
                    }
                }
            }
        }

        return $links;
    }

    public static function get_internal_links( $post_id ) {
        $inbound_links  = self::get_inbound_internal_links( $post_id );
        $outbound_links = self::get_outbound_internal_links( $post_id );

        return [
            'inbound_links'  => $inbound_links,
            'outbound_links' => $outbound_links,
        ];
    }

    public static function get_inbound_internal_links_in_category( $post_id ) {
        $post_categories = get_the_category( $post_id );
        $category_ids    = array_map(
            function( $cat ) {
                return $cat->term_id;
            },
            $post_categories
        );

        $args = [
            'post_type'      => [ 'post', 'page' ],
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'category__in'   => $category_ids,
        ];

        $query = new \WP_Query( $args );
        $links = [];

        foreach ( $query->posts as $post ) {
            if ( $post->ID !== $post_id && stripos( $post->post_content, get_permalink( $post_id ) ) !== false ) {
                $anchor_text = self::get_anchor_text( $post->post_content, get_permalink( $post_id ) );
                $links[]     = [
                    'ID'          => $post->ID,
                    'title'       => $post->post_title,
                    'type'        => $post->post_type,
                    'categories'  => get_the_category_list( ', ', '', $post->ID ),
                    'anchor_text' => $anchor_text,
                ];
            }
        }

        return $links;
    }

    public static function get_outbound_internal_links_in_category( $post_id ) {
        $home_url = home_url();
        $post     = get_post( $post_id );
        $content  = $post->post_content;
        $links    = [];

        $post_categories = get_the_category( $post_id );
        $category_ids    = array_map(
            function( $cat ) {
                return $cat->term_id;
            },
            $post_categories
        );

        if ( preg_match_all( '/<a\s[^>]*href=["\']([^"\']+)["\'][^>]*>/i', $content, $matches ) ) {
            foreach ( $matches[1] as $url ) {
                if ( strpos( $url, $home_url ) === 0 ) {
                    $linked_post_id = url_to_postid( $url );
                    if ( $linked_post_id && $linked_post_id !== $post_id ) {
                        $linked_post_categories   = get_the_category( $linked_post_id );
                        $linked_post_category_ids = array_map(
                            function( $cat ) {
                                return $cat->term_id;
                            },
                            $linked_post_categories
                        );

                        if ( array_intersect( $category_ids, $linked_post_category_ids ) ) {
                            $linked_post = get_post( $linked_post_id );
                            $anchor_text = self::get_anchor_text( $content, $url );
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
        }

        return $links;
    }


    public static function get_anchor_text( $content, $url ) {
        $pattern = '/<a\s[^>]*href=["\']' . preg_quote( $url, '/' ) . '["\'][^>]*>(.*?)<\/a>/i';
        if ( preg_match( $pattern, $content, $matches ) ) {
            return $matches[1];
        }
        return '';
    }

    public static function get_outbound_internal_links_in_category_new( $post_id ) {
        $links = [];

        $post_categories = get_the_category( $post_id );
        $category_ids    = array_map(
            function( $cat ) {
                return $cat->term_id;
            },
            $post_categories
        );

        foreach ( $category_ids as $category_id ) {
            $main_post_for_category = get_term_meta( $category_id, 'wpil_main_post_for_category', true );
            if ( $main_post_for_category == $post_id ) {
                $links = array_merge( self::get_outbound_link_for_main_post( $post_id, $category_id ), $links );
            }
        }

        return $links;
    }

    public function get_outbound_link_for_main_post( $post_id, $category_id ) {
        $outbound_links              = self::get_outbound_internal_links( $post_id );
        $outbound_links_for_category = array_filter(
            $outbound_links,
            function( $link ) use ( $category_id ) {
                $categories = $link['categories'];
                return in_array( $category_id, $categories );
            }
        );
        return $outbound_links_for_category;
    }


    public static function get_inbound_internal_links_in_category_from_main( $post_sub_id ) {
        $categories = wp_get_post_categories( $post_sub_id );
        $main_posts = [];

        foreach ( $categories as $category_id ) {
            $main_post_id = get_term_meta( $category_id, 'wpil_main_post_for_category', true );
            if ( ! empty( $main_post_id ) ) {
                $main_posts[] = $main_post_id;
            }
        }

        $total_links  = 0;
        $link_details = [];

        foreach ( $main_posts as $main_post_id ) {
            $main_post_content  = get_post_field( 'post_content', $main_post_id );
            $post_sub_permalink = get_permalink( $post_sub_id );

            if ( preg_match_all( '/<a\s[^>]*href=["\']' . preg_quote( $post_sub_permalink, '/' ) . '["\'][^>]*>(.*?)<\/a>/i', $main_post_content, $matches ) ) {
                $link_count   = count( $matches[0] );
                $total_links += $link_count;

                foreach ( $matches[0] as $key => $match ) {
                    $link_details[] = [
                        'main_post_id' => $main_post_id,
                        'anchor_text'  => $matches[1][ $key ],
                        'link'         => $match,
                    ];
                }
            }
        }

        return $total_links;
    }

    public static function count_outbound_links_between_posts( $post_id_1, $post_id_2 ) {
        $post_1_content   = get_post_field( 'post_content', $post_id_1 );
        $post_2_permalink = get_permalink( $post_id_2 );

        $link_count = substr_count( $post_1_content, 'href="' . $post_2_permalink . '"' );

        return $link_count;
    }
}
