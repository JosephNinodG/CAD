$(document).ready(function() {
	checkReload();

	window.onpopstate = function(event) {
		if (document.location.href.includes('editEventDetails.php')) {
			loadView('editEventDetails.php');
			return;
		}

		if (document.location.href.includes('sidebar.php')) {
			loadView('seminars.php');
			return;
		}
	}

	loadView('seminars.php');

	// Causes issues with back button
	$('body').on('click tap', '[data-trigger="view-event"]', function(event) {
		event.preventDefault();

		let id = $(this).attr('data-id');

		let url = window.location.hostname;

		history.pushState({}, null, `/CAD/editEventDetails.php?id=${id}`);

		loadView('editEventDetails.php');
	});
});

function checkReload() {
	// This isn't quite working yet
	if (document.location.href.includes('sidebar.php?id=')) {
		loadView('editEventDetails.php');
		return;
	}
}

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
