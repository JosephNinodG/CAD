<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="master.css">
	</head>
	<body>
		<div class="sidenav">
		  <a href="#Dashboard" id="nav-dash">Dashboard</a>
		  <a href="#Profile">Profile</a>
		  <a href="#Logout">Logout</a>
		</div>
		<div class="main" id="content">
			<?php
			session_start();
			$apikey = $_SESSION['apikey'];
			if(!isset($apikey) || $apikey==''){
				//header("Location: .");
				exit;
			}
			$apiurl = "https://reg.bookmein2.com/api/checkinapi.php";

			$data = array('apikey'=>$apikey, 'action' => "getlocationlist");
			$conferenceNameData = array('apikey'=>$apikey, 'action' => "getconferencename");
			$ch = curl_init();

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

			if($confNameResults->success){
					$confName=$confNameResults->data;


			}else{
				$confNameSuccess = false;
				$error = $confNameResults->error;
			}

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

			if($results->success){
				foreach($results->data->list as $seminar){
					$seminars[]  = $seminar;
				}
			}else{
				$success = false;
				$error = $results->error;
			}

			?>
			<div class="container-fluid">
			<?php
			if($success){
				$seminarCount = 0;
				foreach($seminars as $seminar){
					if ($seminar->event_type=="Seminar") {

					echo "<div class='seminarBox' data-trigger='view-event' data-id='$seminar->id'>";
					echo "<div class='row'>";
					echo "<div class='col-5'>$confName</div>";
					$dateOf=date('M j', strtotime($seminar->start_time));
					$startTime=date('H:i', strtotime($seminar->start_time));
					$endTime=date('H:i', strtotime($seminar->end_time));
					echo "<div class='col-sm'>Date: $dateOf</div>";
					echo "<div class='col-sm'>Time: $startTime - $endTime</div>";

					//echo "<div class='col-sm'>End: $endTime</div>";
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

					$seminarCount++;
					}
				}

			}else{
				echo "<div class='row'>Unable to get results: $error</div>";
			}

			echo ("<div class='row'> $seminarCount locations found</div>");
			?>
			<div id='feedback'>

			</div><!-- This closes the feedback div -->
			</div><!-- This closes the bootsrap container -->

		</div>
	</body>
	<footer>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="seminars.js" type="text/javascript"></script>
	</footer>
</html>