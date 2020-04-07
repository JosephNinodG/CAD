$(document).ready(function() {
	loadView('seminars.php');

	$('body').on('click tap', '[data-trigger="view-event"]', function(event) {
		event.preventDefault();

		let id = $(this).attr('data-id');

		let url = window.location.href;

		history.pushState({}, null, url+`?id=${id}`);

		loadView('editEventDetails.php');
	});
});

function loadView(url) {
	$.when(
		getContainerView(url)
	).done(function(html) {
		$('body').find('#content').html(html);
	});
}

function getContainerView(url) {
	return $.ajax({
        url: url,
        dataType: 'HTML',
    });
}
