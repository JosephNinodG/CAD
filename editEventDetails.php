<?php

	session_start();

	// If apikey not set redirect to login page
	if (!isset($_SESSION['apikey'])) {
		header("Location: index.php");
		exit();
	}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/176870990a.js" crossorigin="anonymous"></script>
		<script src="https://cdn.tiny.cloud/1/44tuep5jmn2ahu9y2iv6e6u3n7srjy2odh8nht32st8jyexs/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
        <link rel="stylesheet" href="master.css">
        <title>Event Details</title>
	</head>
	<body>
		<!-- Nav bars -->
		<?php include('mobileNav.php'); ?>
		<?php include('sidebarNav.php'); ?>
		<div class="main" id="content">
	        <div class="container">
	            <form id="details-form" >
					<div class="row pt-3" data-target="edit-row">
	                    <div class="col text-right">
	                        <button type="submit" class="btn btn-warning mb-2" data-trigger="edit-details">EDIT</button>
	                    </div>
	                </div>
	                <div class="row pt-3 sticky hide" data-target="progress-row">
	                    <div class="col">
	                        <div class="progress">
	                            <div class="progress-bar" role="progressbar" style="width: 12.5%;" aria-valuenow="12.5" aria-valuemin="0" aria-valuemax="100">12.5%</div>
	                        </div>
	                    </div>
	                </div>
	                <!-- <div class="row pt-3">
	                    <div class="col">
	                    	<div class="cover-image-container" data-target="cover-image-container"></div>
	                    </div>
	                </div>
	                <div class="row pt-3 hide" data-target="cover-image-row">
	                    <div class="col text-right">
	                        <button type="submit" class="btn btn-secondary mb-2" data-target="upload-cover-image">UPLOAD COVER IMAGE</button>
							<button type="button" class="btn btn-danger mb-2" data-trigger="remove-image" disabled><i class="fas fa-trash"></i></button>
	                    </div>
	                </div> -->
	                <div class="row pt-3">
	                    <div class="col">
							<div class="row pt-3">
								<div class="col-sm-6 col-md-5">
									<div class="form-group">
			                            <label for="seminar-start-time">Start Time</label>
			                            <input type="text" data-target="seminar-start-time" name="seminar-start-time" class="form-control" id="seminar-start-time" aria-describedby="start-time-help" readonly>
			                            <small id="start-time-help" class="form-text text-muted">This has already been set for you.</small>
			                        </div>
								</div>
								<div class="col-sm-6 col-md-5">
									<div class="form-group">
			                            <label for="seminar-end-time">End Time</label>
			                            <input type="text" data-target="seminar-end-time" name="seminar-end-time" class="form-control" id="seminar-end-time" aria-describedby="end-time-help" readonly>
			                            <small id="end-time-help" class="form-text text-muted">This has already been set for you.</small>
			                        </div>
								</div>
							</div>
	                        <div class="form-group">
	                            <label for="seminar-title">Title</label>
	                            <input type="text" data-target="seminar-title" name="seminar-title" class="form-control" id="seminar-title" aria-describedby="title-help" readonly>
	                            <small id="title-help" class="form-text text-muted">This has already been set for you.</small>
	                        </div>
	                        <div class="form-group">
	                            <label for="seminar-type">Presentation Type</label>
	                            <select class="form-control" id="seminar-type" disabled>
	                                <option value="">Select</option>
									<option value="Seminar">Seminar</option>
									<option value="Video Presentation">Video Presentation</option>
									<option value="Workshop">Workshop</option>
	                            </select>
	                        </div>
	                        <div class="form-group">
	                            <label for="seminar-short-description">Short Description</label>
	                            <textarea style="resize: none" id="seminar-short-description" class="form-control textarea-short-description" rows="2" maxlength="100" aria-describedby="short-description-help" disabled></textarea>
								<small id="short-description-help" class="form-text text-muted">Max 100 characters. Any additional characters will be stripped.  <span data-target="desc-current-chars">0/100 characters</span></small>
	                        </div>
	                        <div class="form-group">
	                            <label for="seminar-long-description">Long Description</label>
	                            <textarea style="resize: none" id="seminar-long-description" class="form-control textarea-long-description" rows="3" disabled></textarea>
	                        </div>
	                        <div class="form-group">
	                            <label for="seminar-short-biography">Short Biography</label>
	                            <textarea style="resize: none" id="seminar-short-biography" class="form-control textarea-short-biography" rows="2" maxlength="255" aria-describedby="short-biography-help" disabled></textarea>
								<small id="short-biography-help" class="form-text text-muted">Max 255 characters. Any additional characters will be stripped. <span data-target="bio-current-chars">0/255 characters</span></small>
	                        </div>
	                        <div class="form-group">
	                            <label for="seminar-long-biography">Long Biography</label>
	                            <textarea style="resize: none" id="seminar-long-biography" class="form-control textarea-long-biography" rows="3" disabled></textarea>
	                        </div>
	                    </div>
	                </div>
	                <div class="row hide" data-target="presentation-row">
	                    <div class="col text-right">
	                        <button type="submit" class="btn btn-secondary mb-2" data-target="upload-presentation">UPLOAD PRESENTATION</button>
	                    </div>
	                </div>
	                <div class="row" data-target="files-container"></div>
	                <div class="row hide" data-target="save-row">
	                    <div class="col text-right">
	                        <button type="submit" class="btn btn-warning mb-2" data-target="save-details">SAVE</button>
	                        <button type="submit" class="btn btn-dark mb-2" data-target="cancel-details">CANCEL</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	        <!-- Modals -->
			<div id="cover-image-modal" class="modal" tabindex="-1" role="dialog">
	            <div class="modal-dialog" role="document">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h5 class="modal-title">Upload Cover Image</h5>
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                        </button>
	                    </div>
	                    <form action='post' id="cover-image-form" enctype="multipart/form-data">
	                        <div class="modal-body">
								<div class="alert alert-danger" role="alert" data-target="cover-image-error" style="display: none;"></div>
	                            <div class="form-group">
	                                <input id="cover-image-file" name="cover-image-file" type="file" />
									<small class="form-text text-muted">Note: only .jpg .jpeg and .png files are permitted.</small>
	                            </div>
	                        </div>
	                        <div class="modal-footer">
	                            <button type="submit" class="btn btn-dark" data-trigger="file-upload">UPLOAD</button>
	                            <button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>

	        <div id="presentation-modal" class="modal" tabindex="-1" role="dialog">
	            <div class="modal-dialog" role="document">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h5 class="modal-title">Upload Presentation</h5>
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                        </button>
	                    </div>
	                    <form action='post' id="presentation-form" enctype="multipart/form-data">
	                        <div class="modal-body">
								<div class="alert alert-danger" role="alert" data-target="presentation-error" style="display: none;"></div>
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
	                                <input id="presentation-file" name="presentation-file" type="file" />
									<small class="form-text text-muted">Note: only .jpg .jpeg .png .pdf .ppt and .pptx files are permitted.</small>
	                            </div>
	                        </div>
							<input type="text" name="post-id" value="" data-target="presentation-post-id" hidden>
	                        <div class="modal-footer">
	                            <button type="submit" class="btn btn-dark" data-trigger="file-upload">UPLOAD</button>
	                            <button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>

			<div id="lightbox-modal" class="modal" tabindex="-1" role="dialog">
	            <div class="modal-dialog modal-lg" role="document">
	                <div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Cover Image</h5>
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                        </button>
	                    </div>
						<div data-target="lightbox-image"></div>
					</div>
	            </div>
	        </div>
		</div>
    </body>
    <footer>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="eventDetails.js" type="text/javascript"></script>
    </footer>
</html>
