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

// get post vars
$vars = json_decode($_POST['data']);

// Remove new lines that will break api call
$short_bio = substr(str_replace(array("\r", "\n"), '', $vars->short_bio), 0, 255); // can only be 255 characters long
$long_bio = str_replace(array("\r", "\n"), '', $vars->long_bio);
$first_name = $vars->first_name;
$last_name = $vars->last_name;

// set curl array
$data = array(
	'action' => 'updateprofile',
	'apikey' => $apikey,
	'first_name' => $first_name,
	'last_name' => $last_name,
	'short_bio' => $short_bio,
	'bio' => $long_bio,
);

// only overwrite profile image if posted
if (isset($vars->profile->data)) {
	$data['profileimage'] = $vars->profile->data;
};

// attempt curl
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

// update session 'name' var to new user name (updates sidebar nav)
$_SESSION['name'] = ucfirst($data['first_name']).' '.ucfirst($data['last_name']);

// if profileimage was set, updated session 'profile-img' to new profile image (updates sidebar nav)
if (isset($data['profileimage'])) {
	$_SESSION['profile-img'] = '<img class="img-fluid" src="data:image/png;base64, '.$data['profileimage'].'">';
};

// return response
echo json_encode($response);
return;
