<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="wrap">
    <h1><?php esc_html_e( 'Settings', 'wpinternallinks' ); ?></h1>
    <p><?php esc_html_e( 'Welcome to the WP Internal Links plugin settings page.', 'wpinternallinks' ); ?></p>

    <form method="post" action="options.php">
        <?php
        settings_fields( 'wpinternallinks_settings' );
        do_settings_sections( 'internal-links-settings' );
        submit_button();
        ?>
    </form>
</div>
