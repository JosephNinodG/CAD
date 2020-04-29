$(document).ready(function() {
	window.formValues = {};
	window.file = {};

	initiateView();

	$('body').on('click tap', '[data-trigger="edit-profile"]', function(event) {
		event.preventDefault();

		// Initiate editors on textareas
		initTinymce();

		// Enable edit mode
		enableEdit();
	});

	$('body').on('click tap', '[data-trigger="cancel-profile"]', function(event) {
		event.preventDefault();

		revertFields();

		initReadonlyTinymce();

		// Scroll back to top of page
		$('html, body').animate({ scrollTop: 0 }, 'slow');
	});

	$('body').on('click tap', '[data-target="upload-profile-image"]', function(event) {
		event.preventDefault();

		$('body').find('#profile-image-modal').modal('show');
	});

	// On submit of cover image upload, upload and display image
	$(document).on("submit", "#cover-image-form", function(event){
        event.preventDefault();

		// When upload is done, show error or display image
        $.when(
            doImageUpload(this)
        ).done(function(file) {
			// If error, show error message
            if (file.error) {
				$('body').find('[data-target="profile-image-error"]').html(file.errorMsg);
				$('body').find('[data-target="profile-image-error"]').show();
            } else {
				// Hide any previous errors
				$('body').find('[data-target="profile-image-error"]').hide();

				// Show the image
                displayImage(file.file);

				window.file = file.file;

				// Hide modal
                $('body').find('#profile-image-modal').modal('hide');
            }
        });
    });

	// On click of save details, update event details
    $('body').on('click tap', '[data-target="save-profile"]', function() {
        event.preventDefault();

		saveFormValues();

		updateProfile();

		// Remove the tinymce editors
		tinymce.remove();

		initReadonlyTinymce();

		// Disable edit functionality
		disableEdit();

		// Scroll back to top of page
		$('html, body').animate({ scrollTop: 0 }, 'slow');
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
	$('body').find('[data-target="first-name"]').val(data.first_name);
	$('body').find('[data-target="last-name"]').val(data.last_name);
	$('body').find('#user-short-biography').val(data.short_bio);
	$('body').find('#user-long-biography').val(data.long_bio);

	if (data.profile) {
		let html = `<img class="img-fluid" src="data:image/png;base64, ${data.profile}">`;

		// Set profile image
		$('body').find('#profile-form [data-target="profile-image-container"]').html(html);
	}

	window.startValues = {
		'first_name' : data.first_name,
		'last_name' : data.last_name,
		'short_bio' : data.short_bio,
		'long_bio' : data.long_bio,
		'profile' : data.profile,
	};

	initReadonlyTinymce();
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

function initReadonlyTinymce() {
	// Remove the readonly tinymce editors
	tinymce.remove();

	tinymce.init({
		selector: '.textarea-short-biography',
		readonly: 1,
		menubar:false,
		statusbar: false,
		toolbar:false
	});

	tinymce.init({
		selector: '.textarea-long-biography',
		readonly: 1,
		menubar:false,
		statusbar: false,
		toolbar:false
	});

	$('body').find('[data-target="bio-current-chars"]').html($('body').find('#user-short-biography').val().length + '/255 characters');
}

function enableEdit() {
	$('body').find('[data-target="first-name"]').attr('disabled', false);
	$('body').find('[data-target="last-name"]').attr('disabled', false);

	$('body').find('[data-target="save-row"]').removeClass('hide');
	$('body').find('[data-target="profile-image-row"]').removeClass('hide');
	$('body').find('[data-target="edit-row"]').addClass('hide');
}

function revertFields() {
	$('body').find('[data-target="first-name"]').attr('disabled', true);
	$('body').find('[data-target="last-name"]').attr('disabled', true);

	$('body').find('[data-target="first-name"]').val(window.startValues['first_name']);
	$('body').find('[data-target="last-name"]').val(window.startValues['last_name']);
	$('body').find('#user-short-biography').val(window.startValues['short_bio']);
	$('body').find('#user-long-biography').val(window.startValues['long_bio']);

	let html = `<img class="img-fluid" src="data:image/png;base64, ${window.startValues['profile']}">`;

	// Set profile image
	$('body').find('#profile-form [data-target="profile-image-container"]').html(html);

	$('body').find('[data-target="save-row"]').addClass('hide');
	$('body').find('[data-target="profile-image-row"]').addClass('hide');
	$('body').find('[data-target="edit-row"]').removeClass('hide');
}

// Ajax call to do image file upload
function doImageUpload($this) {
    return $.ajax({
        url: 'imageUpload.php',
        type: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        data: new FormData($this),
    });
}

// Process and display uploaded profile image
function displayImage(file) {
	// Format html for the profile image
	let html = `<img class="img-fluid" src="data:image/png;base64, ${file.data}">`;

	// Set profile image
	$('body').find('#profile-form [data-target="profile-image-container"]').html(html);
}

function saveFormValues() {
	window.formValues.first_name = $('body').find('[data-target="first-name"]').val();
	window.formValues.last_name = $('body').find('[data-target="last-name"]').val();
	window.formValues.shortBiography = tinymce.editors['user-short-biography'].getContent();
	window.formValues.longBiography = tinymce.editors['user-long-biography'].getContent();
}

function updateProfile() {
	$.when(
		attemptSave()
	).done(function(data) {
		if (data.error) {
			return;
		}

		if (window.file) {
			let html = `<img class="img-fluid" src="data:image/png;base64, ${window.file.data}">`;

			// Set profile image
			$('body').find('.sidenav [data-target="profile-image-container"]').html(html);
		}
	});
}

function attemptSave() {
	let data = JSON.stringify({
		'first_name': window.formValues.first_name,
		'last_name': window.formValues.last_name,
		'short_bio': window.formValues.shortBiography,
		'long_bio': window.formValues.longBiography,
		'profile': window.file,
	});

	return $.ajax({
        url: 'saveProfileAPI.php',
        type: 'POST',
        dataType: 'JSON',
        data: { data },
    });
}

function disableEdit() {
	$('body').find('[data-target="first-name"]').attr('disabled', true);
	$('body').find('[data-target="last-name"]').attr('disabled', true);

	$('body').find('[data-target="save-row"]').addClass('hide');
	$('body').find('[data-target="profile-image-row"]').addClass('hide');
	$('body').find('[data-target="edit-row"]').removeClass('hide');
}
