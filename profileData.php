<?php

$response = [
	'error' 	=> false,
	'errorMsg' 	=> '',
	'data'  	=> [],
];

session_start();

if (!isset($_SESSION['apikey'])) {
	$response['error'] = true;
	$response['errorMsg'] = 'No valid apikey found';
	echo json_encode($response);
	return;
}
$apikey = $_SESSION['apikey'];

$url = "heeps://reg.bookmein2.com/api/checkinapi.php";
$postData = array('apikey'=>$apikey, 'action' => "getprofile");

$postData = http_build_query($postData);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
$result=curl_exec ($ch);
curl_close($ch);

$result= json_decode($result);

$seminars = array();
$success=true;

if($results->success){
	foreach($results->data->list as $seminars){
		$seminars[] = $seminar;
	}
}else{
	$success=false;
	$error=$results->error;
}
echo $result
?>