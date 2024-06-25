
const wpInternalLinks = {
    showInfoInternalLinks ($) {
        jQuery('.inbound-links-count, .outbound-links-count, .inbound-links-in-category-count, .outbound-links-in-category-count').on('click', function(e) {
            e.preventDefault();
            const postId = jQuery(this).data('post-id');
            const linkType = jQuery(this).data('type');
    
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
                    console.log(response.data.html);
                    if (response.success && response.data.html) {
                        // Show popup with response.data.html
                        const $popup = $('<div class="wp-internal-links-popup"></div>').html(response.data.html);
                        const title = response.data.title;
                        $popup.dialog({
                            title: title,
                            width: 600,
                            modal: true,
                            buttons: {
                                Close: function() {
                                    $(this).dialog("close");
                                }
                            }
                        });
                    } else {
                        alert('Not have internal links information.');
                    }
                  }
                },
              });
        });
    },
    getInfoSuggest($) {
        jQuery('.wpil-table-suggested-button-copy').on('click', function(e) {
            e.preventDefault();
            console.log(1111);
        });
    },
    copyLinkPost($) {
        jQuery('.wpil-copy-link').on('click', function(e) {
            e.preventDefault();
            const postURL = jQuery(this).data('post-url');
            const $temp = jQuery("<input>");
            jQuery("body").append($temp);
            $temp.val(postURL).select();
            document.execCommand("copy");
            $temp.remove();
            alert('Copy link success!');
        });
    
    }
}

jQuery(document).ready(function($) {
    wpInternalLinks.showInfoInternalLinks($);
    wpInternalLinks.getInfoSuggest($);
    wpInternalLinks.copyLinkPost($);
});