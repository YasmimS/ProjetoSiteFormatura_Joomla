jQuery.noConflict();

jQuery(document).ready(function ($) {
	// check update 
	jQuery('#jform_params_template_updates-lbl').hide();

	var $update = jQuery('#gk_template_updates');
	var $check = jQuery('.gk-version-check');
	var $version = jQuery('.gk-tpl-version');

	var tplVersion = $update.attr('data-gktplversion');
	$version.text(tplVersion);
	$check.show();

	var tpl = $update.attr('data-tpl');
	var gkparams = Joomla.getOptions('gkparams');
	var juri_root = gkparams.juri_root;
	var token = gkparams.token;
	var url = juri_root + '?template=' + tpl + '&tmpl=gkupdate&token=' + token;

	setTimeout(function () {
		jQuery.ajax({
			url: url,
			dataType: 'json'
		})
		.done(function(data) {
			$check.html(data.msg);
		})
		.fail(function() {
			$check.html('<div calss="gk-msg gk-error">Check update failed!</div>');
		})
	}, 300)

	jQuery('#jform_params_asset_js-lbl').parents().eq(1).css('display', 'none');
	jQuery('#jform_params_asset_css-lbl').parents().eq(1).css('display', 'none');
	
	if ($('#style-form').length) {
		$('.switcher').addClass('btn-group btn-group-yesno');

		// Turn radios into btn-group
		$('.radio.btn-group label').addClass('btn');

		$('fieldset.btn-group').each(function () {
			// Handle disabled, prevent clicks on the container, and add disabled style to each button
			if ($(this).prop('disabled')) {
				$(this).css('pointer-events', 'none').off('click');
				$(this).find('.btn').addClass('disabled');
			}
		});

		$('.btn-group label:not(.active)').off().unbind().click(function ()
		{
			var label = $(this);
			var input = $('#' + label.attr('for'));

			if (!input.prop('checked'))
			{
				label.closest('.btn-group').find('label').removeClass('active btn-success btn-danger btn-primary');

				if (label.closest('.btn-group').hasClass('btn-group-reversed'))
				{
					if (input.val() == '')
					{
						label.addClass('active btn-primary');
					} else if (input.val() == 0)
					{
						label.addClass('active btn-success');
					} else
					{
						label.addClass('active btn-danger');
					}
				} else
				{
					if (input.val() == '')
					{
						label.addClass('active btn-primary');
					} else if (input.val() == 0)
					{
						label.addClass('active btn-danger');
					} else
					{
						label.addClass('active btn-success');
					}

				}
				input.prop('checked', true);
				input.trigger('change');
			}
		});
		$('.btn-group input[checked=checked]').each(function ()
		{
			var $self = $(this);
			var attrId = $self.attr('id');

			if ($self.parent().hasClass('btn-group-reversed'))
			{
				if ($self.val() == '')
				{
					$('label[for=' + attrId + ']').addClass('active btn-primary');
				} else if ($self.val() == 0)
				{
					$('label[for=' + attrId + ']').addClass('active btn-success');
				} else
				{
					$('label[for=' + attrId + ']').addClass('active btn-danger');
				}
			} else
			{
				if ($self.val() == '')
				{
					$('label[for=' + attrId + ']').addClass('active btn-primary');
				} else if ($self.val() == 0)
				{
					$('label[for=' + attrId + ']').addClass('active btn-danger');
				} else
				{
					$('label[for=' + attrId + ']').addClass('active btn-success');
				}
			}
		});
	}
});