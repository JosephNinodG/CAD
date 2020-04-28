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
$short_bio = substr(str_replace(array("\r", "\n"), '', $vars->short_bio), 0, 255); // can only be 255 characters long
$long_bio = str_replace(array("\r", "\n"), '', $vars->long_bio);
$first_name = $vars->first_name;
$last_name = $vars->last_name;

$data = array(
	'action' => 'updateprofile',
	'apikey' => $apikey,
	'first_name' => $first_name,
	'last_name' => $last_name,
	'short_bio' => $short_bio,
	'bio' => $long_bio,
);

if (isset($vars->profile->data)) {
	$data['profileimage'] = $vars->profile->data;
};

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

if ($data['profileimage']) {
	$_SESSION['profile-img'] = '<img class="img-fluid" src="data:image/png;base64, '.$data['profileimage'].'">';
};

echo json_encode($response);
return;
