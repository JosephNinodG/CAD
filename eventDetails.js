$(document).ready(function() {
	tinymce.init({
		selector: '.textarea-short-description',
		init_instance_callback: function(editor) {
			editor.on('change', function(e) {
				updateProgressBar();
			});
		}
    });

	tinymce.init({
		selector: '.textarea-long-description',
			init_instance_callback: function(editor) {
			editor.on('change', function(e) {
				updateProgressBar();
			});
		}
    });

	tinymce.init({
		selector: '.textarea-short-biography',
		init_instance_callback: function(editor) {
			editor.on('change', function(e) {
				updateProgressBar();
			});
		}
    });

	tinymce.init({
		selector: '.textarea-long-biography',
		init_instance_callback: function(editor) {
			editor.on('change', function(e) {
				updateProgressBar();
			});
		}
    });

    window.completePercent = 12.5;
    window.filesToUpload = {};
	window.imageToUpload = {};
    window.formValues = {
		'seminarType'		: $('body').find('#seminar-type').val(),
        'shortDescription'  : tinymce.editors['seminar-short-description'].getContent(),
        'longDescription'   : tinymce.editors['seminar-long-description'].getContent(),
        'shortBiography'    : tinymce.editors['seminar-short-biography'].getContent(),
        'longBiography'     : tinymce.editors['seminar-long-biography'].getContent(),
    }

    $('body').on('click tap', '[data-target="save-details"]', function() {
        event.preventDefault();

		updateEventDetails();
    });

    $('body').on('click tap', '[data-target="cancel-details"]', function() {
        event.preventDefault();

		// window.location.href = "";
    });

    $('body').on('click tap', '[data-target="upload-presentation"]', function() {
        event.preventDefault();

        $('body').find('#presentation-modal').modal('show');
    });

    $('body').on('click tap', '[data-target="upload-cover-image"]', function() {
        event.preventDefault();

		$('body').find('#cover-image-modal').modal('show');
    });

    $('body #details-form').on('change paste', ':input', function() {
		updateProgressBar();
    });

    $(document).on("submit", "#presentation-form", function(event){
        event.preventDefault();

		let currentFiles = Object.keys(window.filesToUpload).length;

        $.when(
            doUpload(this)
        ).done(function(file) {
            if (file.error) {
                $('body').find('[data-target="presentation-error"]').html(file.errorMsg);
				$('body').find('[data-target="presentation-error"]').show();
            } else {
				$('body').find('[data-target="presentation-error"]').hide();
                processFile(file.file);
                $('body').find('#presentation-modal').modal('hide');
				updateProgressBarAfterUpload(currentFiles);
            }
        });
    });

	$(document).on("submit", "#cover-image-form", function(event){
        event.preventDefault();

		let currentImage = Object.keys(window.imageToUpload).length;

        $.when(
            doImageUpload(this)
        ).done(function(file) {
            if (file.error) {
				$('body').find('[data-target="cover-image-error"]').html(file.errorMsg);
				$('body').find('[data-target="cover-image-error"]').show();
            } else {
				$('body').find('[data-target="cover-image-error"]').hide();
                displayFile(file.file);
				$('body').find('[data-trigger="remove-image"]').attr('disabled', false);
                $('body').find('#cover-image-modal').modal('hide');
				updateProgressBarAfterImageUpload(currentImage);
            }
        });
    });

    $('body').on('click tap', '[data-trigger="remove-file"]', function(event) {
        event.preventDefault();

        let $this = $(this);
        let deleteFile = confirm('Are you sure you want to remove this file?');
        let parentFile = $(this).parents('[data-file-container]');
		let currentFiles = Object.keys(window.filesToUpload).length;

        if (deleteFile) {
            delete window.filesToUpload[$this.attr('data-file')];
            parentFile.remove();
			updateProgressBarAfterUpload(currentFiles);
        }
    });

	$('body').on('click tap', '[data-trigger="remove-image"]', function(event) {
		event.preventDefault();

		let currentImage = Object.keys(window.imageToUpload).length;
		let deleteImage = confirm('Are you sure you want to remove the cover image?');

		if (deleteImage) {
            window.imageToUpload = {};
            $('body').find('[data-target="cover-image-container"]').html('');
			$('body').find('[data-trigger="remove-image"]').attr('disabled', true);
			updateProgressBarAfterImageUpload(currentImage);
        }
	});
});

function updateEventDetails() {
	// submit data via API
}

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

function updateProgressBarAfterUpload(currentFiles) {
	if (currentFiles == 0 && Object.keys(window.filesToUpload).length > 0) {
        window.completePercent += 12.5;
    }

    if (currentFiles > 0 && Object.keys(window.filesToUpload).length == 0) {
        window.completePercent -= 12.5;
    }

	animateProgressBar();

	return;
}

function updateProgressBarAfterImageUpload(currentImage) {
	if (currentImage == 0 && Object.keys(window.imageToUpload).length > 0) {
        window.completePercent += 12.5;
    }

    if (currentImage > 0 && Object.keys(window.imageToUpload).length == 0) {
        window.completePercent -= 12.5;
    }

	animateProgressBar();

	return;
}

function updateProgressBar() {
	if (window.formValues.seminarType == "" && $('body').find('#seminar-type').val().trim() != "") {
        window.formValues.seminarType = $('body').find('#seminar-type').val().trim();
        window.completePercent += 12.5;
    }

    if (window.formValues.seminarType != "" && $('body').find('#seminar-type').val().trim() == "") {
        window.formValues.seminarType = $('body').find('#seminar-type').val().trim();
        window.completePercent -= 12.5;
    }

    if (window.formValues.shortDescription == "" && tinymce.editors['seminar-short-description'].getContent() != "") {
        window.formValues.shortDescription = tinymce.editors['seminar-short-description'].getContent();
        window.completePercent += 12.5;
    }

    if (window.formValues.shortDescription != "" && tinymce.editors['seminar-short-description'].getContent() == "") {
        window.formValues.shortDescription = tinymce.editors['seminar-short-description'].getContent();
        window.completePercent -= 12.5;
    }

    if (window.formValues.longDescription == "" && tinymce.editors['seminar-long-description'].getContent() != "") {
        window.formValues.longDescription = tinymce.editors['seminar-long-description'].getContent();
        window.completePercent += 12.5;
    }

    if (window.formValues.longDescription != "" && tinymce.editors['seminar-long-description'].getContent() == "") {
        window.formValues.longDescription = tinymce.editors['seminar-long-description'].getContent();
        window.completePercent -= 12.5;
    }

    if (window.formValues.shortBiography == "" && tinymce.editors['seminar-short-biography'].getContent() != "") {
        window.formValues.shortBiography = tinymce.editors['seminar-short-biography'].getContent();
        window.completePercent += 12.5;
    }

    if (window.formValues.shortBiography != "" && tinymce.editors['seminar-short-biography'].getContent() == "") {
        window.formValues.shortBiography = tinymce.editors['seminar-short-biography'].getContent();
        window.completePercent -= 12.5;
    }

    if (window.formValues.longBiography == "" && tinymce.editors['seminar-long-biography'].getContent() != "") {
        window.formValues.longBiography = tinymce.editors['seminar-long-biography'].getContent();
        window.completePercent += 12.5;
    }

    if (window.formValues.longBiography != "" && tinymce.editors['seminar-long-biography'].getContent() == "") {
        window.formValues.longBiography = tinymce.editors['seminar-long-biography'].getContent();
        window.completePercent -= 12.5;
    }

	animateProgressBar();

    return;
}

function animateProgressBar() {
    let percent = window.completePercent;

    percent = percent + '%';

    $(".progress-bar").animate({
        width: percent
    }, 1000);

    $(".progress-bar").attr('aria-valuenow', percent);
    $(".progress-bar").html(percent);
}

function processFile(file) {
    window.filesToUpload[file.title] = {
        'title'     : file.title,
        'name'      : file.name,
        'purpose'   : file.purpose,
        'data'      : file.data
    }

    showFile(file);
}

function showFile(file) {
    let html;
    let fileLayout = "";
    let container = $('body').find('[data-target="files-container"]').html();
    let icon = '<i class="far fa-file-powerpoint"></i>';

    if (file.type == 'jpg' || file.type == 'png') {
        icon = '<i class="far fa-file-image"></i>';
    }

    let fileName = `${file.name}.${file.type}`;

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

    html = `<div class="col-auto" data-file-container>`;
    html += fileLayout;
    html += '</div>';

    $('body').find('[data-target="files-container"]').html(container + html);
}

function displayFile(file) {
	window.imageToUpload = {
        'name'      : file.name,
        'data'      : file.data
    }

	let html = `<img class="img-fluid cover-image" src="data:image/png;base64, ${file.data}" onclick="openLightbox($(this))">`;

	$('body').find('[data-target="cover-image-container"]').html(html);
}

function openLightbox($this) {
	$('body').find('[data-target="lightbox-image"]').html($this);
	$('body').find('#lightbox-modal').modal('show');
}
