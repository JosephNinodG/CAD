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
		$_SESSION['apikey'] = $results->data->apikey;
		header("Location: seminars.php");
		exit;
	}else{
		echo "Unable to login.  Error: ".$results->data->message;
	}
}else{
	echo "Unable to login.  Error: ".$results->error;
}

?>