<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<?php
session_start();
$apikey = $_SESSION['apikey'];
if(!isset($apikey) || $apikey==''){
	//header("Location: .");
	exit;
}
$apiurl = "https://reg.bookmein2.com/api/checkinapi.php";

$data = array('apikey'=>$apikey, 'action' => "getlocationlist");
$conferenceNameData = array('apikey'=>$apikey, 'action' => "getconferencename");
$ch = curl_init();

$params = http_build_query($data);
$paramsConfName = http_build_query($conferenceNameData);
$getUrl = $apiurl."?".$params;
$getConferenceNameUrl = $apiurl."?".$paramsConfName;


curl_setopt($ch, CURLOPT_URL, $getConferenceNameUrl);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$confNameOutput = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);

$confNameResults = json_decode($confNameOutput);

$confNameArray = array();
$confNameSuccess = true;

if($confNameResults->success){
		$confName=$confNameResults->data;


}else{
	$confNameSuccess = false;
	$error = $confNameResults->error;
}




$ch = curl_init();
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
<style>
	body {
		background-color: black;
	}
	.seminarBox {
		background-color: white;
	}
	.percentageComp {
		text-align:right;
		color:red;
	}
	hr {
		border: 3px solid black;
		border-radius:2px;
		margin-right:5px;
		margin-left:5px;
	}

</style>
</head>
<body>
<div class="container-fluid">
<?php
if($success){
	$seminarCount = 0;
	foreach($seminars as $seminar){
		if ($seminar->event_type=="Seminar") {
		echo "<div class='seminarBox'>";
		echo "<div class='row'>";
		echo "<div class='col-4'>$confName</div>";
		echo "<div class='col-sm'>Start: {$seminar->start_time}</div>";
		echo "<div class='col-sm'>End: {$seminar->end_time}</div>";
		echo "<div class='col-sm percentageComp' >0% complete! </div>";
		echo "</div>";
		echo "<hr/>";
		echo "<div class='row'>";
		// echo "<div class='col-sm'>{$seminar->id}</div>";
		// echo "<div class='col-sm'>{$seminar->event_type}</div>";
		echo "<div class='col'><h2>{$seminar->name}</h2></div>";
		echo "</div>";
		echo "</div>";

		echo "<br/><br/>";

		$seminarCount++;
		}
	}

}else{
	echo "<div class='row'>Unable to get results: $error</div>";
}

echo ("<div class='row'> $seminarCount locations found</div>");
?>
<div id='feedback'>

</div><!-- This closes the feedback div -->
</div><!-- This closes the bootsrap container -->

</body>
</html>
