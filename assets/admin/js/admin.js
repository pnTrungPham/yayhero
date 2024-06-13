jQuery(document).ready(function($) {
    jQuery('.inbound-links-count, .outbound-links-count').on('click', function(e) {
        e.preventDefault();
        const postId = jQuery(this).data('post-id');
        const linkType = $(this).hasClass('inbound-links-count') ? 'inbound' : 'outbound';

        jQuery.ajax({
            url: wp_internal_links.ajax_url,
            type: 'POST',
            data: {
                action: 'get_internal_links_info',
                nonce: wp_internal_links.nonce,
                post_id: postId,
                link_type: linkType
            },
            success: function (response) {
              if (response.success === true) {
                if (response.success && response.data.html) {
                    // Show popup with response.data.html
                    console.log(response.data.html);
                    var $popup = $('<div class="wp-internal-links-popup"></div>').html(response.data.html);
                    $popup.dialog({
                        title: linkType === 'inbound' ? 'Inbound Internal Links' : 'Outbound Internal Links',
                        width: 600,
                        modal: true,
                        buttons: {
                            Close: function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                } else {
                    alert('Failed to fetch internal links information.');
                }
              }
            },
          });
    });
});