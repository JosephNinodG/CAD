$(document).ready(function() {
    let completePercent = 12.5;

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
            console.log(file);
        });
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
