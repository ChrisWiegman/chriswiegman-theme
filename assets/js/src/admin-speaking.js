jQuery(document).ready(function ($) {

	function handleMulti() {

		// Setup repeating form field add handler.
		$(document.getElementById('add-row')).on('click', function () {

			var row = $('.empty-row.screen-reader-text').clone(true);

			console.log($('#repeatable-fieldset tbody>tr:last'));

			row.removeClass('empty-row screen-reader-text');
			row.insertBefore('#repeatable-fieldset tbody>tr.main:last');

			return false;

		});

	}

	handleMulti();

	// Setup repeating form field remove handler
	$('.remove-row').on('click', function () {

		$(this).closest('tr.main').remove();

		return false;

	});

	// Add datepicker to presentation date.
	$('#presentation_date').datepicker();

});