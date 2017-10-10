jQuery(document).ready(function ($) {

	function handleMulti() {

		// Setup repeating form field add handler.
		$(document.getElementById('add-row')).on('click', function () {

			var row = $('.empty-row.screen-reader-text').clone(true);

			row.removeClass('empty-row screen-reader-text');
			row.insertBefore('#repeatable-fieldset tbody>tr.main:last');

			$('.date-field').each(function () {

				if (0 === $(this).closest('.empty-row').length) {

					$(this).datepicker('destroy');
					$(this).datepicker();

				}
			});

			return false;

		});

	}

	handleMulti();

	// Setup repeating form field remove handler
	$('.remove-row').on('click', function () {

		$(this).closest('tr.main').remove();

		return false;

	});

	$('.date-field').each(function () {
		$(this).datepicker();
	});

});