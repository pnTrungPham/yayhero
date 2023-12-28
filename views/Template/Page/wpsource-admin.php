<?php
defined( 'ABSPATH' ) || exit;
?>

<style>
    #wpcontent #wpbody .notice {
        display: none;
    }
    #wpfooter {
        display: none;
    }
    #adminmenumain {
        display: none;
    }
    #wpcontent {
        margin: 0;
        padding: 0;
    }
</style>

<div id="wpsource-app">
    <?php echo do_shortcode( '[my_custom_shortcode]' ); ?>
</div> 
