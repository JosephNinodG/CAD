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
		$_SESSION['apikey'] = $results->data->apikey;
		header("Location: seminars.php"); //redirect to seminars.php, accessing the main user page
		exit;
	}else{
		header("Location: index.php?badpass=1"); // if login info incorrect redirect back to login page with badpass=1 to allow error message to display
	}
}else{
	echo "Unable to login.  Error: ".$results->error; // if cannot access api, display error message and link to take back to login page
	echo "<br/>";
	echo "<a href='index.php'>Return to Login Page</a>";
}

?>