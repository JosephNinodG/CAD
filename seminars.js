$(document).ready(function() {
	$('body').on('click tap', '[data-trigger="view-event"]', function(event) {
		event.preventDefault();

		let id = $(this).attr('data-id');

		location.href = `editEventDetails.php?id=${id}`;
	});

	$('body').on('keyup', '[data-trigger="search-seminars"]', function() {
		let searchString = $(this).val();
		let seminars = $('body').find('[data-target="seminar-box"]');

		$.each(seminars, function() {
			if (!$(this).attr('data-name').toLowerCase().includes(searchString.toLowerCase())) {
				$(this).addClass('hide');
			} else {
				$(this).removeClass('hide');
			}
		});
	});
});
