<?php
defined( 'ABSPATH' ) || exit;
?>

<style>
    #wpcontent #wpbody .notice,
    #wpcontent #wpbody .updated {
        display: none;
    }
    #wpfooter {
        display: none;
    }
    #adminmenumain {
        display: none;
    }
    #wpcontent {
        margin: 0!important;
        padding: 0!important;
    }
    #wpadminbar {
        display: none!important;
    }
    html.wp-toolbar {
        padding-top: 0!important;
    }
    @media screen and (max-width: 782px) {
        #wpcontent {
            margin: 0!important;
            padding: 0!important;
        }
    }
    @media screen and (max-width: 600px) {
        #wpbody {
            margin: 0!important;
            padding: 0!important;
        }
    }
</style>

<div id="wpsource-app">
    <?php echo do_shortcode( '[my_custom_shortcode]' ); ?>
</div> 
