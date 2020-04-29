<?php
session_start(); //start new session
$apiurl = "https://reg.bookmein2.com/api/checkinapi.php"; //stores api url
$data = array( //stores data from login page form in array
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

if($results->success){ //if can access api then success
	if($results->data->loggedin){ // if login info correct then log in
		$apikey = $results->data->apikey;

		// Profile Details
		$url = 'https://reg.bookmein2.com/api/checkinapi.php';
		$urlstring = '?action=getprofile&apikey='.$apikey;
		$url = $url.$urlstring;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$profile = curl_exec($ch);

		curl_close($ch);

		if (!$profile) {
			header("Location: index.php?badpass=1"); // if can't access user profile redirect back to login page with badpass=2 to allow error message to display
			exit();
		}

		$profile = json_decode($profile);

		if ($profile->success == false) {
			header("Location: index.php?badpass=1"); // if can't access user profile redirect back to login page with badpass=2 to allow error message to display
			exit();
		}

		// Set SESSION data with Apikey and user data
		$_SESSION['apikey'] = $apikey;
		$_SESSION['name'] = $profile->data->first_name.' '.$profile->data->last_name;
		$_SESSION['profile-img'] = '';

		if (!empty($profile->data->profile)) {
			$_SESSION['profile-img'] = '<img class="img-fluid" src="data:image/png;base64, '.$profile->data->profile.'">';
		}

		header("Location: seminars.php"); //redirect to seminars.php, accessing the main user page
		exit;
	}else{
		header("Location: index.php?badpass=1"); // if login info incorrect redirect back to login page with badpass=1 to allow error message to display
		exit();
	}
}else{
	echo "Unable to login.  Error: ".$results->error;
	echo "<br/>";
	echo "<a href='index.php'>Return to Login Page</a>";
}

?>
