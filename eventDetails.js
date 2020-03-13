$(document).ready(function() {
    let completePercent = 12.5;

    window.filesToUpload = {};

    window.formValues = {
        'shortDescription'  : $('body').find('#seminar-short-description').val(),
        'longDescription'   : $('body').find('#seminar-long-description').val(),
        'shortBiography'    : $('body').find('#seminar-short-biography').val(),
        'longBiography'     : $('body').find('#seminar-long-biography').val(),
    }

    $('body').on('click tap', '[data-target="save-details"]', function() {
        event.preventDefault();
    });

    $('body').on('click tap', '[data-target="cancel-details"]', function() {
        event.preventDefault();
    });

    $('body').on('click tap', '[data-target="upload-presentation"]', function() {
        event.preventDefault();

        $('body').find('#presentation-modal').modal('show');
    });

    $('body').on('click tap', '[data-target="upload-cover-image"]', function() {
        event.preventDefault();
    });

    $('body #details-form').on('change paste', ':input', function() {
        $.when(
            updateProgressBar(completePercent)
        ).done(function(percent) {
            completePercent = percent;
            animateProgressBar(completePercent);
        });
    });

    $(document).on("submit", "#presentation-form", function(event){
        event.preventDefault();

        $.when(
            doUpload(this)
        ).done(function(file) {
            if (file.error) {
                // show error
            } else {
                processFile(file.file);
                $('body').find('#presentation-modal').modal('hide');
            }
        });
    });

    $('body').on('click tap', '[data-trigger="remove-file"]', function(event) {
        event.preventDefault();

        let $this = $(this);
        let deleteFile = confirm('Are you sure you want to remove this file?');
        let parentFile = $(this).parents('[data-file-container]');

        if (deleteFile) {
            delete window.filesToUpload[$this.attr('data-file')];
            parentFile.remove();
        }
    });
});

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

function updateProgressBar(completePercent) {
    if (window.formValues.shortDescription == "" && $('body').find('#seminar-short-description').val().trim() != "") {
        window.formValues.shortDescription = $('body').find('#seminar-short-description').val().trim();
        completePercent += 12.5;
    }

    if (window.formValues.shortDescription != "" && $('body').find('#seminar-short-description').val().trim() == "") {
        window.formValues.shortDescription = $('body').find('#seminar-short-description').val().trim();
        completePercent -= 12.5;
    }

    if (window.formValues.longDescription == "" && $('body').find('#seminar-long-description').val().trim() != "") {
        window.formValues.longDescription = $('body').find('#seminar-long-description').val().trim();
        completePercent += 12.5;
    }

    if (window.formValues.longDescription != "" && $('body').find('#seminar-long-description').val().trim() == "") {
        window.formValues.longDescription = $('body').find('#seminar-long-description').val().trim();
        completePercent -= 12.5;
    }

    if (window.formValues.shortBiography == "" && $('body').find('#seminar-short-biography').val().trim() != "") {
        window.formValues.shortBiography = $('body').find('#seminar-short-biography').val().trim();
        completePercent += 12.5;
    }

    if (window.formValues.shortBiography != "" && $('body').find('#seminar-short-biography').val().trim() == "") {
        window.formValues.shortBiography = $('body').find('#seminar-short-biography').val().trim();
        completePercent -= 12.5;
    }

    if (window.formValues.longBiography == "" && $('body').find('#seminar-long-biography').val().trim() != "") {
        window.formValues.longBiography = $('body').find('#seminar-long-biography').val().trim();
        completePercent += 12.5;
    }

    if (window.formValues.longBiography != "" && $('body').find('#seminar-long-biography').val().trim() == "") {
        window.formValues.longBiography = $('body').find('#seminar-long-biography').val().trim();
        completePercent -= 12.5;
    }

    // Add in Image + Presentations

    return completePercent;
}

function animateProgressBar(completePercent) {
    let percent = completePercent;

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
    let fileLayout;
    let container = $('body').find('[data-target="files-container"]').html();
    let icon = '<i class="far fa-file-powerpoint"></i>';

    if (file.type == 'jpg' || file.type == 'png') {
        icon = '<i class="far fa-file-image"></i>';
    }

    let fileName = `${file.name}.${file.type}`;

    fileLayout = `<div class="input-group mb-3">`;
    fileLayout += `<div class="input-group-prepend">`;
    fileLayout += `<span class="input-group-text" id="icon-for-${fileName}">${icon}</span>`;
    fileLayout += `</div>`;
    fileLayout += `<input type="text" class="form-control" aria-label="Username" aria-describedby="icon-for-${fileName}" readonly value="${fileName}">`;
    fileLayout += `<div class="input-group-append">`;
    fileLayout += `<button class="btn btn-danger" type="button" data-trigger="remove-file" data-file="${file.title}"><i class="fas fa-trash"></i></button>`;
    fileLayout += `</div>`;
    fileLayout += `</div>`;

    html = `<div class="col-auto" data-file-container>`;
    html += fileLayout;
    html += '</div>';

    $('body').find('[data-target="files-container"]').html(container + html);
}
