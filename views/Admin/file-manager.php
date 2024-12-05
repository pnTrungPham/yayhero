<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="wps-file-manager-container">
    <div id="wps-file-connected">
    connected
    </div>
</div>

<script>
jQuery(document).ready(function() {
  jQuery('#wps-file-connected').elfinder({
    url: ajaxurl,
    customData: {
      action: 'wps_fm_connector',
      nonce: '<?php echo wp_create_nonce( 'rpfm-admin-nonce' ); ?>'
    },
    lang: 'LANG',
    requestType: 'post',
    width: 'auto',
    height: '600',
  });
});
</script>
