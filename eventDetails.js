$(document).ready(function() {
	// On click of edit button, change from view to edit
	$('body').on('click tap', '[data-trigger="edit-details"]', function(event) {
		event.preventDefault();

		// How the form starts to revert back to on cancel
		window.startValues = {
			'coverImage'		: $('body').find('[data-target="cover-image-container"]').html(),
			'seminarType'		: $('body').find('#seminar-type').val(),
	        'shortDescription'  : $('body').find('#seminar-short-description').val(),
	        'longDescription'   : $('body').find('#seminar-long-description').val(),
	        'shortBiography'    : $('body').find('#seminar-short-biography').val(),
	        'longBiography'     : $('body').find('#seminar-long-biography').val(),
	    }

		// Initiate editors on textareas
		initTinymce();

		// Enable edit mode
		enableEdit();
	});

	// Default values
    window.completePercent = 12.5;
    window.filesToUpload = {};
	window.imageToUpload = {};

	// On click of save details, update event details
    $('body').on('click tap', '[data-target="save-details"]', function() {
        event.preventDefault();

		updateEventDetails();
    });

	// On click of cancel, discard unsaved changes
    $('body').on('click tap', '[data-target="cancel-details"]', function() {
        event.preventDefault();

		// Remove the tinymce editors
		tinymce.remove();

		// Disable edit functionality
		disableEdit();

		// Revert unsaved changes
		revertFields();

		// Scroll back to top of page
		$('html, body').animate({ scrollTop: 0 }, 'slow');
    });

	// On click of upload presentation, show upload modal
    $('body').on('click tap', '[data-target="upload-presentation"]', function() {
        event.preventDefault();

        $('body').find('#presentation-modal').modal('show');
    });

	// On click of upload cover image, show upload modal
    $('body').on('click tap', '[data-target="upload-cover-image"]', function() {
        event.preventDefault();

		$('body').find('#cover-image-modal').modal('show');
    });

	// On change or paste of form inputs, update the progress bar
    $('body #details-form').on('change paste', ':input', function() {
		updateProgressBar();
    });

	// On submit of presentation upload, upload and display presentation
    $(document).on("submit", "#presentation-form", function(event){
        event.preventDefault();

		// Get current files to compare against to update progress bar
		let currentFiles = Object.keys(window.filesToUpload).length;

		// When upload is done, show error or display file
        $.when(
            doUpload(this)
        ).done(function(file) {
			// If error
            if (file.error) {
				// Show error message
                $('body').find('[data-target="presentation-error"]').html(file.errorMsg);
				$('body').find('[data-target="presentation-error"]').show();
            } else {
				// Hide any previous errors
				$('body').find('[data-target="presentation-error"]').hide();

				// Process and display file
                processFile(file.file);

				// Hide modal
                $('body').find('#presentation-modal').modal('hide');

				// Update progress bar
				updateProgressBarAfterUpload(currentFiles);
            }
        });
    });

	// On submit of cover image upload, upload and display image
	$(document).on("submit", "#cover-image-form", function(event){
        event.preventDefault();

		// Get current image to compare against to update progress bar
		let currentImage = Object.keys(window.imageToUpload).length;

		// When upload is done, show error or display image
        $.when(
            doImageUpload(this)
        ).done(function(file) {
			// If error, show error message
            if (file.error) {
				$('body').find('[data-target="cover-image-error"]').html(file.errorMsg);
				$('body').find('[data-target="cover-image-error"]').show();
            } else {
				// Hide any previous errors
				$('body').find('[data-target="cover-image-error"]').hide();

				// Show the image
                displayImage(file.file);

				// Allow removal of image
				$('body').find('[data-trigger="remove-image"]').attr('disabled', false);

				// Hide modal
                $('body').find('#cover-image-modal').modal('hide');

				// Update progress bar
				updateProgressBarAfterImageUpload(currentImage);
            }
        });
    });

	// On click of remove file, remove presentation file
    $('body').on('click tap', '[data-trigger="remove-file"]', function(event) {
        event.preventDefault();

		// Set variables
        let $this = $(this);
		let parentFile = $(this).parents('[data-file-container]');
		let currentFiles = Object.keys(window.filesToUpload).length;

		// Show confirmation dialog
        let deleteFile = confirm('Are you sure you want to remove this file?');

		// If permitted
        if (deleteFile) {
			// Remove file from object
            delete window.filesToUpload[$this.attr('data-file')];

			// Remove file html
            parentFile.remove();

			// Update progress bar
			updateProgressBarAfterUpload(currentFiles);
        }
    });

	// On click of remove image, remove cover image
	$('body').on('click tap', '[data-trigger="remove-image"]', function(event) {
		event.preventDefault();

		// Get current image
		let currentImage = Object.keys(window.imageToUpload).length;

		// Show confirmation dialog
		let deleteImage = confirm('Are you sure you want to remove the cover image?');

		// If permitted
		if (deleteImage) {
			// Reset object
			window.imageToUpload = {};

			// Remove file html
			$('body').find('[data-target="cover-image-container"]').html('');

			// Disable remove file button
			$('body').find('[data-trigger="remove-image"]').attr('disabled', true);

			// Update progress bar
			updateProgressBarAfterImageUpload(currentImage);
        }
	});
});

// Initiate the Tinymce editors on textareas
function initTinymce() {
	tinymce.init({
		selector: '.textarea-short-description',

		// On change, update progress bar
		init_instance_callback: function(editor) {
			editor.on('change', function(e) {
				updateProgressBar();
			});
		}
    });

	tinymce.init({
		selector: '.textarea-long-description',

		// On change, update progress bar
		init_instance_callback: function(editor) {
			editor.on('change', function(e) {
				updateProgressBar();
			});
		}
    });

	tinymce.init({
		selector: '.textarea-short-biography',

		// On change, update progress bar
		init_instance_callback: function(editor) {
			editor.on('change', function(e) {
				updateProgressBar();
			});
		}
    });

	tinymce.init({
		selector: '.textarea-long-biography',

		// On change, update progress bar
		init_instance_callback: function(editor) {
			editor.on('change', function(e) {
				updateProgressBar();
			});
		}
    });

	// Set the current form values to compare vs existing in order to update percentage
	window.formValues = {
		'seminarType'		: $('body').find('#seminar-type').val(),
        'shortDescription'  : tinymce.editors['seminar-short-description'].getContent(),
        'longDescription'   : tinymce.editors['seminar-long-description'].getContent(),
        'shortBiography'    : tinymce.editors['seminar-short-biography'].getContent(),
        'longBiography'     : tinymce.editors['seminar-long-biography'].getContent(),
    }
}

// Change view from 'View' to 'Edit'
function enableEdit() {
	// Hide edit button
	$('body').find('[data-target="edit-row"]').hide();

	// Enable seminar select
	$('body').find('#seminar-type').attr('disabled', false);

	// Show edit functionality
	$('body').find('[data-target="progress-row"]').show();
	$('body').find('[data-target="cover-image-row"]').show();
	$('body').find('[data-target="presentation-row"]').show();
	$('body').find('[data-target="save-row"]').show();
}

// Change view from 'Edit' to 'View'
function disableEdit() {
	// Hide edit button
	$('body').find('[data-target="progress-row"]').hide();
	$('body').find('[data-target="cover-image-row"]').hide();
	$('body').find('[data-target="presentation-row"]').hide();
	$('body').find('[data-target="save-row"]').hide();

	// Disable seminar select
	$('body').find('#seminar-type').attr('disabled', true);

	// Show edit button
	$('body').find('[data-target="edit-row"]').show();
}

// Discard any field changes by reverting contents to how they were before edit mode enabled
function revertFields() {
	$('body').find('#seminar-type').val(window.startValues.seminarType);
	$('body').find('#seminar-short-description').val(window.startValues.shortDescription);
	$('body').find('#seminar-long-description').val(window.startValues.longDescription);
	$('body').find('#seminar-short-biography').val(window.startValues.shortBiography);
	$('body').find('#seminar-long-biography').val(window.startValues.longBiography);
	$('body').find('[data-target="cover-image-container"]').html(window.startValues.coverImage);
}

function updateEventDetails() {
	// submit data via API
}

// Ajax call to do presentation file upload
function doUpload($this) {
    return $.ajax({
        url: 'fileUpload.php',
        type: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        data: new FormData($this),
    });
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

// Update progress bar after file upload
function updateProgressBarAfterUpload(currentFiles) {
	// If there were no existing files but files now exist, mark file section as complete
	if (currentFiles == 0 && Object.keys(window.filesToUpload).length > 0) {
        window.completePercent += 12.5;
    }

	// If there were existing files but no files now exist, mark file section as incomplete
    if (currentFiles > 0 && Object.keys(window.filesToUpload).length == 0) {
        window.completePercent -= 12.5;
    }

	// Animate progress change
	animateProgressBar();

	return;
}

// Update progress bar after image upload
function updateProgressBarAfterImageUpload(currentImage) {
	// If there was no existing image but an image now exist, mark image section as complete
	if (currentImage == 0 && Object.keys(window.imageToUpload).length > 0) {
        window.completePercent += 12.5;
    }

	// If there was an existing image but no image now exists, mark image section as incomplete
    if (currentImage > 0 && Object.keys(window.imageToUpload).length == 0) {
        window.completePercent -= 12.5;
    }

	// Animate progress change
	animateProgressBar();

	return;
}

// Update progress bar on form input change
function updateProgressBar() {
	// If seminar type wasn't set but now is, mark section as complete
	if (window.formValues.seminarType == "" && $('body').find('#seminar-type').val().trim() != "") {
        window.formValues.seminarType = $('body').find('#seminar-type').val().trim();
        window.completePercent += 12.5;
    }

	// If seminar type was set but now isn't, mark section as incomplete
    if (window.formValues.seminarType != "" && $('body').find('#seminar-type').val().trim() == "") {
        window.formValues.seminarType = $('body').find('#seminar-type').val().trim();
        window.completePercent -= 12.5;
    }

	// If seminar short description wasn't set but now is, mark section as complete
    if (window.formValues.shortDescription == "" && tinymce.editors['seminar-short-description'].getContent() != "") {
        window.formValues.shortDescription = tinymce.editors['seminar-short-description'].getContent();
        window.completePercent += 12.5;
    }

	// If seminar short description was set but now isn't, mark section as incomplete
    if (window.formValues.shortDescription != "" && tinymce.editors['seminar-short-description'].getContent() == "") {
        window.formValues.shortDescription = tinymce.editors['seminar-short-description'].getContent();
        window.completePercent -= 12.5;
    }

	// If seminar long description wasn't set but now is, mark section as complete
    if (window.formValues.longDescription == "" && tinymce.editors['seminar-long-description'].getContent() != "") {
        window.formValues.longDescription = tinymce.editors['seminar-long-description'].getContent();
        window.completePercent += 12.5;
    }

	// If seminar long description was set but now isn't, mark section as incomplete
    if (window.formValues.longDescription != "" && tinymce.editors['seminar-long-description'].getContent() == "") {
        window.formValues.longDescription = tinymce.editors['seminar-long-description'].getContent();
        window.completePercent -= 12.5;
    }

	// If seminar short biography wasn't set but now is, mark section as complete
    if (window.formValues.shortBiography == "" && tinymce.editors['seminar-short-biography'].getContent() != "") {
        window.formValues.shortBiography = tinymce.editors['seminar-short-biography'].getContent();
        window.completePercent += 12.5;
    }

	// If seminar short biography was set but now isn't, mark section as incomplete
    if (window.formValues.shortBiography != "" && tinymce.editors['seminar-short-biography'].getContent() == "") {
        window.formValues.shortBiography = tinymce.editors['seminar-short-biography'].getContent();
        window.completePercent -= 12.5;
    }

	// If seminar long biography wasn't set but now is, mark section as complete
    if (window.formValues.longBiography == "" && tinymce.editors['seminar-long-biography'].getContent() != "") {
        window.formValues.longBiography = tinymce.editors['seminar-long-biography'].getContent();
        window.completePercent += 12.5;
    }

	// If seminar long biography was set but now isn't, mark section as incomplete
    if (window.formValues.longBiography != "" && tinymce.editors['seminar-long-biography'].getContent() == "") {
        window.formValues.longBiography = tinymce.editors['seminar-long-biography'].getContent();
        window.completePercent -= 12.5;
    }

	// Animate progress change
	animateProgressBar();

    return;
}

// Animate the progress bar to make it transitions appealing
function animateProgressBar() {
	// Turn complete percent into a string
    let percent = window.completePercent + '%';

	// Animate progress bar over 1 second to new percent complete
    $(".progress-bar").animate({
        width: percent
    }, 1000);

	// Update aria value
    $(".progress-bar").attr('aria-valuenow', percent);

	// Update text
    $(".progress-bar").html(percent);
}

// Process and display presentation
function processFile(file) {
	// Extract file upload results and add to file object
    window.filesToUpload[file.title] = {
        'title'     : file.title,
        'name'      : file.name,
        'purpose'   : file.purpose,
        'data'      : file.data
    }

	// Display the file
    showFile(file);
}

// Display uploaded file
function showFile(file) {
	// Initiate variables
    let html;
    let fileLayout = "";

	// Get html content of files container
    let container = $('body').find('[data-target="files-container"]').html();

	// Default presentation icon
    let icon = '<i class="far fa-file-powerpoint"></i>';

	// If file is an image, change icon
    if (file.type == 'jpg' || file.type == 'png') {
        icon = '<i class="far fa-file-image"></i>';
    }

	// Set the filename
    let fileName = `${file.name}.${file.type}`;

	// Format the html for the file
	fileLayout += `<div class="pt-1 pb-1">`;
	fileLayout += `<label>Document Title: ${file.title}</label>`;
    fileLayout += `<div class="input-group mb-3">`;
    fileLayout += `<div class="input-group-prepend">`;
    fileLayout += `<span class="input-group-text" id="icon-for-${fileName}">${icon}</span>`;
    fileLayout += `</div>`;
    fileLayout += `<input type="text" class="form-control" aria-label="Username" aria-describedby="icon-for-${fileName}" readonly value="${fileName}">`;
    fileLayout += `<div class="input-group-append">`;
    fileLayout += `<button class="btn btn-danger" type="button" data-trigger="remove-file" data-file="${file.title}"><i class="fas fa-trash"></i></button>`;
    fileLayout += `</div>`;
    fileLayout += `</div>`;
	fileLayout += `<small class="form-text text-muted">File Purpose: ${file.purpose}</small>`;
	fileLayout += `</div>`;

	// Add file to new container
    html = `<div class="col-auto" data-file-container>`;
    html += fileLayout;
    html += '</div>';

	// Append new file to existing files
    $('body').find('[data-target="files-container"]').html(container + html);
}

// Process and display uploaded cover image
function displayImage(file) {
	// Extract image upload results and add to object
	window.imageToUpload = {
        'name'      : file.name,
        'data'      : file.data
    }

	// Format html for the cover image
	let html = `<img class="img-fluid cover-image" src="data:image/png;base64, ${file.data}" onclick="openLightbox($(this))">`;

	// Set cover image
	$('body').find('[data-target="cover-image-container"]').html(html);
}

// On click of cover image, display full size image in modal
function openLightbox($this) {
	// Clone the cover image and add to modal body
	$('body').find('[data-target="lightbox-image"]').html($this.clone());

	// Show modal
	$('body').find('#lightbox-modal').modal('show');
}
