<!-- Desktop sidebar -->
<div class="sidenav">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="row pt-3 justify-content-center">
					<div class="col-8">
						<div class="row justify-content-center">
							<img src="/CAD/assets/imgs/logo.png" alt="BookMeIn2">
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
							<p data-target="sidebar-name"><?= $_SESSION['name'] ?></p>
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
							<a class="btn btn-dark btn-block mb-2" href="/CAD/scripts/logout.php">Logout</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
