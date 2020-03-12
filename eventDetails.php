<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="master.css">
        <title>Event Details</title>
    </head>
    <body>
        <div class="container">
            <form id="details-form" >
                <div class="row">
                    <div class="col">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 12.5%;" aria-valuenow="12.5" aria-valuemin="0" aria-valuemax="100">12.5%</div>
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
                            <input type="text" name="seminar-title" class="form-control" id="seminar-title" aria-describedby="title-help" readonly>
                            <small id="title-help" class="form-text text-muted">This has already been set for you.</small>
                        </div>
                        <div class="form-group">
                            <label for="seminar-title">Presentation Type</label>
                            <select class="form-control" id="seminar-type">
                                <option value="">Select</option>
                            </select>
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
        <!-- Modals -->
        <div id="presentation-modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Presentation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="presentation-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="presentation-title">Document Title</label>
                                <input type="text" class="form-control" id="presentation-title" name="presentation-title">
                            </div>
                            <div class="form-group">
                                <label for="presentation-name">File Name</label>
                                <input type="text" class="form-control" id="presentation-name" name="presentation-name">
                            </div>
                            <div class="form-group">
                                <label for="presentation-purpose">File Purpose</label>
                                <input type="text" class="form-control" id="presentation-purpose" name="presentation-purpose">
                            </div>
                            <div class="form-group">
                                <input id="presentation-file" name="presentation-file[]" type="file" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-trigger="file-upload">UPLOAD</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <footer>
        <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="eventDetails.js" type="text/javascript"></script>
    </footer>
</html>
