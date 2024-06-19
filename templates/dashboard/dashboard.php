<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="wrap">
    <h1><?php esc_html_e( 'Dashboard', 'wpinternallinks' ); ?></h1>
    <div> <?php echo do_shortcode( '[wp_internal_links_post_list]' ); ?></div>
</div>
