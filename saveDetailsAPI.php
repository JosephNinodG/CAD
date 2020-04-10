<?php

session_start();
$apikey = $_SESSION['apikey'];

// Default response
$response = [
	'error' 	=> false,
	'errorMsg' 	=> '',
	'data'  	=> [],
];

$vars = json_decode($_POST['data']);

// Remove new lines that will break api call
$id = $vars->id;
$type = $vars->type;
$short_desc = str_replace(array("\r", "\n"), '', $vars->short_desc);
$long_desc = str_replace(array("\r", "\n"), '', $vars->long_desc);
$short_bio = str_replace(array("\r", "\n"), '', $vars->short_bio);
$long_bio = str_replace(array("\r", "\n"), '', $vars->long_bio);

// Check id
if ($id == '') {
	$response['error'] = true;
	$response['errorMsg'] = 'No event id passed';
	echo json_encode($response);
	return;
}

// API URL for setting event details
$url = 'https://reg.bookmein2.com/api/checkinapi.php'.'?action=editlocation&apikey='.$apikey.'&locationid='.$id.'&short_desc='.$short_desc.'&description='.$long_desc.'&presentation_type='.$type;

// Valid id so try details api call
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$details = curl_exec($ch);

curl_close($ch);

if (!$details) {
	$response['error'] = true;
	$response['errorMsg'] = 'Event API failed';
	echo json_encode($response);
	return;
}

$details = json_decode($details);

if (!isset($details->success)) {
	$response['error'] = true;
	$response['errorMsg'] = 'Event API failed';
	echo json_encode($response);
	return;
}

if ($details->success == false) {
	$response['error'] = true;
	$response['errorMsg'] = 'Event API failed';
	echo json_encode($response);
	return;
}

// API URL for setting profile details
$url = 'https://reg.bookmein2.com/api/checkinapi.php'.'?action=updateprofile&apikey='.$apikey.'&short_bio='.$short_bio.'&bio='.$long_bio;

// Valid id so try details api call
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$profile = curl_exec($ch);

curl_close($ch);

if (!$profile) {
	$response['error'] = true;
	$response['errorMsg'] = 'Profile API failed';
	echo json_encode($response);
	return;
}

$profile = json_decode($profile);

if (!isset($profile->success)) {
	$response['error'] = true;
	$response['errorMsg'] = 'Profile API failed';
	echo json_encode($response);
	return;
}

if ($profile->success == false) {
	$response['error'] = true;
	$response['errorMsg'] = 'Profile API failed';
	echo json_encode($response);
	return;
}

echo json_encode($response);
return;
