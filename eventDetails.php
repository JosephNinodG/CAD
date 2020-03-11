<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Event Details</title>
    </head>
    <body>
        <div class="container">
            <form class="needs-validation" id="details-form" novalidate>
                <div class="row">
                    <div class="col">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- Image -->
                    </div>
                </div>
                <div class="row">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-secondary mb-2" data-target="upload-cover-image">UPLOAD COVER IMAGE</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="seminar-title">Title</label>
                            <input type="email" class="form-control" id="seminar-title" aria-describedby="title-help" readonly>
                            <small id="title-help" class="form-text text-muted">This has already been set for you.</small>
                        </div>
                        <div class="form-group">
                            <label for="seminar-short-description">Short Description</label>
                            <textarea style="resize: none" id="seminar-short-description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="seminar-long-description">Long Description</label>
                            <textarea style="resize: none" id="seminar-long-description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="seminar-short-biography">Short Biography</label>
                            <textarea style="resize: none" id="seminar-short-biography" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="seminar-long-biography">Long Biography</label>
                            <textarea style="resize: none" id="seminar-long-biography" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-secondary mb-2" data-target="upload-presentation">UPLOAD PRESENTATION</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-warning mb-2" data-target="save-details">SAVE</button>
                        <button type="submit" class="btn btn-dark mb-2" data-target="cancel-details">CANCEL</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <footer>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="eventDetails.js" type="text/javascript"></script>
    </footer>
</html>
