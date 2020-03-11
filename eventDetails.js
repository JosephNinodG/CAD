$(document).ready(function() {
    $('body').on('click tap', '[data-target="save-details"]', function() {
        event.preventDefault();

        console.log('clicked');
    });

    $('body').on('click tap', '[data-target="cancel-details"]', function() {
        event.preventDefault();

        console.log('clicked');
    });

    $('body').on('click tap', '[data-target="upload-presentation"]', function() {
        event.preventDefault();

        console.log('clicked');
    });

    $('body').on('click tap', '[data-target="upload-cover-image"]', function() {
        event.preventDefault();

        console.log('clicked');
    });
});
