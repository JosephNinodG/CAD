<!-- No direct access -->
<?php if(!defined('accessible')) { header('location: 404.html'); exit(); } ?>

<!-- Mobile Nav -->
<nav class="navbar navbar-expand-lg navbar-light navbar-bg hide">
	<div class="container">
		<div class="row align-items-center justify-content-center w-100">
			<div class="col-2">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-toggle" aria-controls="navbar-toggle" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
			<div class="col-10 text-center">
				<img class="logo" src="/CAD/assets/imgs/logo.png" alt="BookMeIn2">
				<div class="collapse navbar-collapse" id="navbar-toggle">
					<ul class="navbar-nav mt-2 mt-lg-0 text-center">
						<li class="nav-item">
							<a class="btn btn-dark mb-2" class="nav-link" href="seminars.php">Dashboard</a>
						</li>
						<li class="nav-item">
							<a class="btn btn-dark mb-2" class="nav-link" href="editProfile.php">Profile</a>
						</li>
						<li class="nav-item">
							<a class="btn btn-dark mb-2" class="nav-link" href="/CAD/scripts/logout.php">Logout</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</nav>
