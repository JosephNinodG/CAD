<?php

	session_start();

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
        <title>Profile</title>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light navbar-bg hide">
			<div class="container">
				<div class="row align-items-center justify-content-center w-100">
					<div class="col-2">
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-toggle" aria-controls="navbar-toggle" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
					</div>
					<div class="col-10 text-center">
						<img class="logo" src="logo.png" alt="BookMeIn2">
						<div class="collapse navbar-collapse" id="navbar-toggle">
							<ul class="navbar-nav mt-2 mt-lg-0 text-center">
								<li class="nav-item">
									<a class="btn btn-dark mb-2" class="nav-link" href="seminars.php">Dashboard</a>
								</li>
								<li class="nav-item">
									<a class="btn btn-dark mb-2" class="nav-link" href="editProfile.php">Profile</a>
								</li>
								<li class="nav-item">
									<a class="btn btn-dark mb-2" class="nav-link" href="logout.php">Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<div class="sidenav">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="row pt-3 justify-content-center">
							<div class="col-8">
								<div class="row justify-content-center">
									<img src="logo.png" alt="BookMeIn2">
								</div>
							</div>
						</div>
						<div class="row pt-3 justify-content-center">
							<div class="col-8">
								<div class="row justify-content-center">
									<div class="profile-image-container" data-target="profile-image-container">
										<?= $_SESSION['profile-img'] ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row pt-3 justify-content-center">
							<div class="col-8">
								<div class="row justify-content-center">
									<p><?= $_SESSION['name'] ?></p>
								</div>
							</div>
						</div>
						<div class="row pt-3 justify-content-center">
							<div class="col-8">
								<div class="row">
									<a class="btn btn-dark btn-block mb-2" href="seminars.php">Dashboard</a>
								</div>
							</div>
							<div class="col-8">
								<div class="row justify-content-center">
									<a class="btn btn-dark btn-block mb-2" href="editProfile.php">Profile</a>
								</div>
							</div>
							<div class="col-8">
								<div class="row justify-content-center">
									<a class="btn btn-dark btn-block mb-2" href="logout.php">Logout</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="main" id="content">
			<div class="container">
	            <form id="profile-form">
					<div class="row pt-3" data-target="edit-row">
	                    <div class="col text-right">
	                        <button type="submit" class="btn btn-warning mb-2" data-trigger="edit-profile">EDIT</button>
	                    </div>
	                </div>
	                <div class="row pt-3 justify-content-center">
	                    <div class="col-8">
							<div class="row justify-content-center">
	                    		<div class="profile-image-container" data-target="profile-image-container"></div>
							</div>
	                    </div>
	                </div>
	                <div class="row pt-3 justify-content-center">
	                    <div class="col-8">
							<div class="row justify-content-center hide" data-target="profile-image-row">
								<button type="button" class="btn btn-secondary mb-2" data-target="upload-profile-image">UPLOAD PROFILE IMAGE</button>
							</div>
	                    </div>
	                </div>
	                <div class="row pt-3">
	                    <div class="col">
							<div class="row pt-3 justify-content-center">
								<div class="col-sm-6">
									<div class="form-group">
			                            <label for="user-first-name">First Name</label>
			                            <input type="text" data-target="first-name" name="first-name" class="form-control" id="user-first-name" disabled required>
			                        </div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
			                            <label for="user-last-name">Last Name</label>
			                            <input type="text" data-target="last-name" name="last-name" class="form-control" id="user-last-name" disabled required>
			                        </div>
								</div>
							</div>
	                        <div class="form-group">
	                            <label for="user-short-biography">Short Biography</label>
	                            <textarea style="resize: none" id="user-short-biography" class="form-control textarea-short-biography" rows="2" maxlength="255" aria-describedby="short-biography-help" disabled></textarea>
								<small id="short-biography-help" class="form-text text-muted">Max 255 characters. Any additional characters will be stripped. <span data-target="bio-current-chars">0/255 characters</span></small>
	                        </div>
	                        <div class="form-group">
	                            <label for="user-long-biography">Long Biography</label>
	                            <textarea style="resize: none" id="user-long-biography" class="form-control textarea-long-biography" rows="3" disabled></textarea>
	                        </div>
	                    </div>
	                </div>
	        	    <div class="row hide" data-target="save-row">
	                    <div class="col text-right">
	                        <button type="submit" class="btn btn-warning mb-2" data-target="save-profile">SAVE</button>
	                        <button type="submit" class="btn btn-dark mb-2" data-target="cancel-profile">CANCEL</button>
	                    </div>
	                </div>
	            </form>
	        </div>
			<!-- Modals -->
			<div id="profile-image-modal" class="modal" tabindex="-1" role="dialog">
	            <div class="modal-dialog" role="document">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h5 class="modal-title">Upload Profile Image</h5>
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
		</div>
	</body>
	<footer>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="profile.js" type="text/javascript"></script>
    </footer>
</html>