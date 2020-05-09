<?php

// Default response
$response = [
	'error' 	=> false,
	'errorMsg' 	=> '',
	'data'  	=> [],
];

// setup session
session_start();

// if apikey not set then user isn't logged in
if (!isset($_SESSION['apikey'])) {
	$response['error'] = true;
	$response['errorMsg'] = 'No valid apikey found';
	echo json_encode($response);
	return;
}

$apikey = $_SESSION['apikey'];

// Set id
$id = $_POST['id'];

// Check id
if ($id == '') {
	$response['error'] = true;
	$response['errorMsg'] = 'No event id passed';
	echo json_encode($response);
	return;
}

// API URL for getting event details
$url = 'https://reg.bookmein2.com/api/checkinapi.php';
$urlstring = '?action=getlocationdetails&apikey='.$apikey.'&locationid='.$id.'&includefiles=1';
$url = $url.$urlstring;

// Valid id so try details api call
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$details = curl_exec($ch);

curl_close($ch);

// If call failed, error out
if (!$details) {
	$response['error'] = true;
	$response['errorMsg'] = 'API failed';
	echo json_encode($response);
	return;
}

// Decode result to see response
$details = json_decode($details);

// If success is false, error out
if ($details->data->success == false) {
	$response['error'] = true;
	$response['errorMsg'] = 'API failed';
	echo json_encode($response);
	return;
}

// Add data fields from the api
$data['start_time'] = date('d/m/Y g:i A', strtotime($details->data->location->start_time));
$data['end_time'] = date('d/m/Y g:i A', strtotime($details->data->location->end_time));
$data['name'] = $details->data->location->name;
$data['type'] = $details->data->location->presentation_type;
$data['short_desc'] = $details->data->location->short_desc;
$data['long_desc'] = $details->data->location->description;
$data['files'] = $details->data->location->files;

$response['data'] = $data;

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

// If call failed, error out
if (!$profile) {
	$response['error'] = true;
	$response['errorMsg'] = 'API failed';
	echo json_encode($response);
	return;
}

// Decode result to see response
$profile = json_decode($profile);

// If success is false, error out
if ($profile->success == false) {
	$response['error'] = true;
	$response['errorMsg'] = 'API failed';
	echo json_encode($response);
	return;
}

// Add data fields from api
$data['short_bio'] = $profile->data->short_bio;
$data['long_bio'] = $profile->data->biography;

// Return data
$response['data'] = $data;
echo json_encode($response);
return;
