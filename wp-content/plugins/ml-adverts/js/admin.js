jQuery(document).ready(function() {
	if (jQuery("#ml_advert_custom_metaboxes_main").length > 0) {
		var showImageFields = function() {
			jQuery("#ml_advert_html").closest('tr').hide();
			jQuery("#ml_advert_image").closest('tr').show();
			jQuery("#ml_advert_url").closest('tr').show();
			jQuery("#ml_advert_url_mask").closest('tr').show();
		}

		var showHtmlFields = function() {
			jQuery("#ml_advert_html").closest('tr').show();
			jQuery("#ml_advert_image").closest('tr').hide();
			jQuery("#ml_advert_url").closest('tr').hide();
			jQuery("#ml_advert_url_mask").closest('tr').hide();
		}

		jQuery("#ml_advert_type1").click(function() {
			showImageFields();
		});

		jQuery("#ml_advert_type2").click(function() {
			showHtmlFields();
		});

		if (jQuery("#ml_advert_type1").is(":checked")) {
			showImageFields();
		} else if (jQuery("#ml_advert_type2").is(":checked")) {
			showHtmlFields();
		} else {
			jQuery("#ml_advert_type1").attr('checked', 'checked');
			showImageFields();
		}

		jQuery("#ml_advert_custom_metaboxes_restrictions ul").css({
			"overflow" : "auto",
			"max-height" : "200px"
		});

		if (jQuery('#post-status-display:contains("Draft")').length > 0) {
			jQuery('input[type=checkbox]').each( function() {
				if(jQuery(this).val()=='all') {
					jQuery(this).attr('checked', 'checked');
				}
			});
		}
	}

	// posts screen
	if (jQuery(".icon32-posts-ml-advert").length > 0) {
		jQuery('tr td:contains("Inactive")').closest('tr').css('background-color', '#FFF2F2');
	}

	// taxonomy
	if (jQuery(".icon32-posts-ml-advert").length > 0) {
		jQuery("#addtag #tag-slug").closest('div').hide();
		jQuery("#addtag #parent").closest('div').hide();
		jQuery("#addtag #tag-description").closest('div').hide();
		jQuery("label[for=tag-name]").html('Location name');
		jQuery("label[for=tag-name]").siblings('p').html('eg. header, footer, sidebar, below title');
	}
});