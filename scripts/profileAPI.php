<?php

// Default response
$response = [
	'error' 	=> false,
	'errorMsg' 	=> '',
	'data'  	=> [],
];

// setup session
session_start();

// if apikey not set, user not logged in
if (!isset($_SESSION['apikey'])) {
	$response['error'] = true;
	$response['errorMsg'] = 'No valid apikey found';
	echo json_encode($response);
	return;
}

// get apikey
$apikey = $_SESSION['apikey'];

// API URL for getting event details
$url = 'https://reg.bookmein2.com/api/checkinapi.php';
$urlstring = '?action=getprofile&apikey='.$apikey;
$url = $url.$urlstring;

// Valid id so try profile api call
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$profile = curl_exec($ch);

curl_close($ch);

// if no result, error out
if (!$profile) {
	$response['error'] = true;
	$response['errorMsg'] = 'API failed';
	echo json_encode($response);
	return;
}

// decode result to see response
$profile = json_decode($profile);

// if success is false, error out
if ($profile->success == false) {
	$response['error'] = true;
	$response['errorMsg'] = 'API failed';
	echo json_encode($response);
	return;
}

// set data
$data['first_name'] = $profile->data->first_name;
$data['last_name'] = $profile->data->last_name;
$data['short_bio'] = $profile->data->short_bio;
$data['long_bio'] = $profile->data->biography;
$data['profile'] = $profile->data->profile;

// return response
$response['data'] = $data;
echo json_encode($response);
return;
