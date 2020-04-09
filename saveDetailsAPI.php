<?php

session_start();
$apikey = $_SESSION['apikey'];

// Default response
$response = [
	'error' 	=> false,
	'errorMsg' 	=> '',
	'data'  	=> [],
];

// Set id
$id = $_POST['id'];

// Check id
if ($id == '') {
	$response['error'] = true;
	$response['errorMsg'] = 'No event id passed';
	echo json_encode($response);
	return;
}

// // API URL for getting event details
// $url = 'https://reg.bookmein2.com/api/checkinapi.php';
// $urlstring = '?action=getlocationdetails&apikey='.$apikey.'&locationid='.$id.'&includefiles=1';
// $url = $url.$urlstring;
//
// // Valid id so try details api call
// $ch = curl_init();
//
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//
// $details = curl_exec($ch);
//
// curl_close($ch);
//
// if (!$details) {
// 	$response['error'] = true;
// 	$response['errorMsg'] = 'API failed';
// 	echo json_encode($response);
// 	return;
// }
//
// $details = json_decode($details);
//
// if ($details->success == false) {
// 	$response['error'] = true;
// 	$response['errorMsg'] = 'API failed';
// 	echo json_encode($response);
// 	return;
// }
