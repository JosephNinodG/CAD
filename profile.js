$(document).ready(function() {
	initiateView();

	$('body').on('click tap', '[data-trigger="edit-profile"]', function(event) {
		event.preventDefault();

		// Initiate editors on textareas
		initTinymce();

		// Enable edit mode
		enableEdit();
	});
});

function initiateView() {
	$.when(
		getProfile()
	).done(function(data) {
		if (data.error == true) {
			if (data.errorMsg == 'No valid apikey found') {
				window.location.href = 'index.php';
			}
		} else {
			displayView(data.data);
		}
	});
}

function getProfile() {
	return $.ajax({
		url: 'profileAPI.php',
        type: 'POST',
        dataType: 'JSON',
	});
}

function displayView(data) {
	console.log(data)
}

// Initiate the Tinymce editors on textareas
function initTinymce() {
	// Remove the readonly tinymce editors
	tinymce.remove();

	tinymce.init({
		selector: '.textarea-short-biography',

		// On change, update char count
		init_instance_callback: function(editor) {
			editor.on('keyup', function() {
				$('body').find('[data-target="bio-current-chars"]').html(tinymce.editors['user-short-biography'].getContent().length + '/255 characters');

				if (tinymce.editors['user-short-biography'].getContent().length > 255) {
					$('body').find('[data-target="bio-current-chars"]').css('color', 'red');
				} else {
					$('body').find('[data-target="bio-current-chars"]').css('color', '#6c757d');
				}
			});
		},

		menubar:false,
		statusbar: false,
    });

	tinymce.init({
		selector: '.textarea-long-biography',
		menubar:false,
		statusbar: false,
    });
}

function enableEdit() {
	$('body').find('[data-target="save-row"]').removeClass('hide');
	$('body').find('[data-target="profile-image-row"]').removeClass('hide');
}
