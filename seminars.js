$(document).ready(function() {
	$('body').on('click tap', '[data-trigger="view-event"]', function(event) {
		event.preventDefault();

		let id = $(this).attr('data-id');

		location.href = `editEventDetails.php?id=${id}`;
	});
});
