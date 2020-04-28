<?php
	// setup session
	session_start();

	if (!isset($_SESSION['apikey'])) {
		header("Location: index.php");
		exit();
	}

	$apikey = $_SESSION['apikey'];
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
        <title>Dashboard</title>
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
			<?php
			$apiurl = "https://reg.bookmein2.com/api/checkinapi.php";
			//create two calls, one to pull all locations and the other to pull the conference name
			$data = array('apikey'=>$apikey, 'action' => "getlocationlist");
			$conferenceNameData = array('apikey'=>$apikey, 'action' => "getconferencename");
			$ch = curl_init();
			//first pull the conference name
			$params = http_build_query($data);
			$paramsConfName = http_build_query($conferenceNameData);
			$getUrl = $apiurl."?".$params;
			$getConferenceNameUrl = $apiurl."?".$paramsConfName;

			curl_setopt($ch, CURLOPT_URL, $getConferenceNameUrl);

			//return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// $output contains the output string
			$confNameOutput = curl_exec($ch);

			// close curl resource to free up system resources
			curl_close($ch);

			$confNameResults = json_decode($confNameOutput);

			$confNameArray = array();
			$confNameSuccess = true;
			//if the api call is successful, create the confName variable
			if($confNameResults->success){
					$confName=$confNameResults->data;


			}else{
				$confNameSuccess = false;
				$error = $confNameResults->error;
			}
			//reinitialise another api call for the location list/details
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $getUrl);

			//return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// $output contains the output string
			$output = curl_exec($ch);

			// close curl resource to free up system resources
			curl_close($ch);

			$results = json_decode($output);

			$seminars = array();
			$success = true;
			//if successful, create array of seminars and their details
			if($results->success){
				foreach($results->data->list as $seminar){
					$seminars[]  = $seminar;
				}
			}else{
				$success = false;
				$error = $results->error;
			}

			?>
			<div class="container-fluid pt-5">
			<?php
			if($success){
				//use a counter to tally the total seminars being shown
				$seminarCount = 0;
				foreach($seminars as $seminar){
					if ($seminar->event_type=="Seminar") {
						//if the event is a seminar, create a box containing a variety of details for each
					echo "<div class='seminarBox' data-trigger='view-event' data-id='$seminar->id'>";
					echo "<div class='row'>";
					echo "<div class='col-5'>$confName</div>";
					$dateOf=date('M j', strtotime($seminar->start_time));
					$startTime=date('H:i', strtotime($seminar->start_time));
					$endTime=date('H:i', strtotime($seminar->end_time));
					echo "<div class='col-sm'>Date: $dateOf</div>";
					echo "<div class='col-sm'>Time: $startTime - $endTime</div>";

					//echo "<div class='col-sm'>End: $endTime</div>";
					//percentage complete to be pulled using the edit event details page.
					echo "<div class='col-sm percentageComp' >0% complete! </div>";
					echo "</div>";
					echo "<hr/>";
					echo "<div class='row'>";
					// echo "<div class='col-sm'>{$seminar->id}</div>";
					// echo "<div class='col-sm'>{$seminar->event_type}</div>";
					echo "<div class='col'><h2>{$seminar->name}</h2></div>";
					echo "</div>";
					echo "</div>";

					echo "<br/>";
					//increase the seminar tally now that a new box has been added
					$seminarCount++;

					}
				}

			}else{
				//if the api call was unsuccessful, throw an error
				echo "<div class='row'>Unable to get results: $error</div>";
			}
			//end the container with the updated seminar count
			// echo ("<div class='row'> $seminarCount locations found</div>");
			?>
			<!-- Include section for feedback that can be updated by certain errors -->
			<div id='feedback'>

			</div><!-- This closes the feedback div -->
			</div><!-- This closes the bootsrap container -->

		</div>
	</body>
	<footer>
		<!-- Include the necessary dependancies -->
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="seminars.js" type="text/javascript"></script>
	</footer>
</html>
