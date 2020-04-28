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

$data = array(
	'action' => 'editlocation',
	'apikey' => $apikey,
	'locationid' => $id,
	'short_desc' => $short_desc,
	'description' => $long_desc,
	'presentation_type' => $type,
);

$ch = curl_init('https://reg.bookmein2.com/api/checkinapi.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// execute
$details = curl_exec($ch);

// close the connection
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

$data = array(
	'action' => 'updateprofile',
	'apikey' => $apikey,
	'short_bio' => $short_bio,
	'bio' => $long_bio,
);

$ch = curl_init('https://reg.bookmein2.com/api/checkinapi.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// execute
$profile = curl_exec($ch);

// close the connection
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
