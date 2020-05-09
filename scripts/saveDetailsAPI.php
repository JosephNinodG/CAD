<?php

// start session
session_start();

// get apikey
$apikey = $_SESSION['apikey'];

// Default response
$response = [
	'error' 	=> false,
	'errorMsg' 	=> '',
	'data'  	=> [],
];

// get iost data
$vars = json_decode($_POST['data']);

// Remove new lines that will break api call
$id = $vars->id;
$type = $vars->type;
$short_desc = substr(str_replace(array("\r", "\n"), '', $vars->short_desc), 0, 100); // can only be 100 characters long
$long_desc = str_replace(array("\r", "\n"), '', $vars->long_desc);
$short_bio = substr(str_replace(array("\r", "\n"), '', $vars->short_bio), 0, 255); // can only be 255 characters long
$long_bio = str_replace(array("\r", "\n"), '', $vars->long_bio);

// Check id
if ($id == '') {
	$response['error'] = true;
	$response['errorMsg'] = 'No event id passed';
	echo json_encode($response);
	return;
}

// set curl array
$data = array(
	'action' => 'editlocation',
	'apikey' => $apikey,
	'locationid' => $id,
	'short_desc' => $short_desc,
	'description' => $long_desc,
	'presentation_type' => $type,
);

// attempt curl
$ch = curl_init('https://reg.bookmein2.com/api/checkinapi.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// execute
$details = curl_exec($ch);

// close the connection
curl_close($ch);

// if no result, error out
if (!$details) {
	$response['error'] = true;
	$response['errorMsg'] = 'Event API failed';
	echo json_encode($response);
	return;
}

// deode result to see response
$details = json_decode($details);

// if success isn't set, error out
if (!isset($details->success)) {
	$response['error'] = true;
	$response['errorMsg'] = 'Event API failed';
	echo json_encode($response);
	return;
}

// if success is false, error out
if ($details->success == false) {
	$response['error'] = true;
	$response['errorMsg'] = 'Event API failed';
	echo json_encode($response);
	return;
}

// set curl data
$data = array(
	'action' => 'updateprofile',
	'apikey' => $apikey,
	'short_bio' => $short_bio,
	'bio' => $long_bio,
);

// attemp curl
$ch = curl_init('https://reg.bookmein2.com/api/checkinapi.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// execute
$profile = curl_exec($ch);

// close the connection
curl_close($ch);

// if no result, error out
if (!$profile) {
	$response['error'] = true;
	$response['errorMsg'] = 'Profile API failed';
	echo json_encode($response);
	return;
}

// decode result to see response
$profile = json_decode($profile);

// if success not set, error out
if (!isset($profile->success)) {
	$response['error'] = true;
	$response['errorMsg'] = 'Profile API failed';
	echo json_encode($response);
	return;
}

// if success is false, error out
if ($profile->success == false) {
	$response['error'] = true;
	$response['errorMsg'] = 'Profile API failed';
	echo json_encode($response);
	return;
}

// return response
echo json_encode($response);
return;
