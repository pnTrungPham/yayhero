<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="wrap wpil-dashboard-page">
    <div class="logo">
        <img src="<?php echo esc_url( WP_INTERNAL_LINKS_PLUGIN_URL . 'assets/admin/images/logo.png' ); ?>" alt="WP Internal Links">
        <h2>Report & Cluster Cockpit</h2>
    </div>

    <div> <?php echo do_shortcode( '[wp_internal_links_post_list]' ); ?></div>
</div>
