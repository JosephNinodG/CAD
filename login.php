<?php
session_start();
$apiurl = "https://reg.bookmein2.com/api/checkinapi.php";
$data = array(
					'username' => $_POST['username'],
					'password' => $_POST['password'],
					'eventref' => $_POST['eventref'],
					'action' => "login"
					);
$params = http_build_query($data);
$getUrl = $apiurl."?".$params;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $getUrl);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);

$results = json_decode($output);

if($results->success){
	if($results->data->loggedin){
		$apikey = $results->data->apikey;

		// Profile Details
		$url = 'https://reg.bookmein2.com/api/checkinapi.php';
		$urlstring = '?action=getprofile&apikey='.$apikey;
		$url = $url.$urlstring;

		// Valid id so try profile api call
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$profile = curl_exec($ch);

		curl_close($ch);

		if (!$profile) {
			header("Location: index.php");
			exit();
		}

		$profile = json_decode($profile);

		if ($profile->success == false) {
			header("Location: index.php");
			exit();
		}

		$_SESSION['apikey'] = $apikey;
		$_SESSION['name'] = $profile->data->first_name.' '.$profile->data->last_name;
		$_SESSION['short_bio'] = $profile->data->short_bio;
		$_SESSION['long_bio'] = $profile->data->long_bio;
		$_SESSION['profile-img'] = '';

		if (!empty($profile->data->profile)) {
			$_SESSION['profile-img'] = '<img class="img-fluid" src="data:image/png;base64, '.$profile->data->profile.'">';
		}

		header("Location: seminars.php");
		exit;
	}else{
		echo "Unable to login.  Error: ".$results->data->error;
		echo "<br/>";
		echo "<a href='index.php'>Return to Login Page</a>";
	}
}else{
	echo "Unable to login.  Error: ".$results->error;
	echo "<br/>";
	echo "<a href='index.php'>Return to Login Page</a>";
}

?>
