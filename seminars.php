<?php
session_start();
$apikey = $_SESSION['apikey'];
if(!isset($apikey) || $apikey==''){
	//header("Location: .");
	exit;
}
$apiurl = "https://reg.bookmein2.com/api/checkinapi.php";

$data = array('apikey'=>$apikey, 'action' => "getlocationlist");

$ch = curl_init();

$params = http_build_query($data);
$getUrl = $apiurl."?".$params;

curl_setopt($ch, CURLOPT_URL, $getUrl);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);  

$results = json_decode($output);

$seminars = array();
$success = true;

if($results->success){
	foreach($results->data->list as $seminar){
		$seminars[]  = $seminar;
	}
}else{
	$success = false;
	$error = $results->error;
}

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

<table id='seminars' border='1'>
<thead><tr><th>ID</th><th>Type</th><th>Name</th></thead>
<tbody id='seminarbody'>
<?php
if($success){
	foreach($seminars as $seminar){
		echo "<tr>";
		echo "<td>{$seminar->id}</td>";
		echo "<td>{$seminar->event_type}</td>";
		echo "<td>{$seminar->name}</td>";
		echo "</tr>";
	}
}else{
	echo "<tr><td colspan='3'>Unable to get results: $error</td></tr>";
}	
?>
</tbody>
</table>
<div id='feedback'>

</div>

</body>
</html>