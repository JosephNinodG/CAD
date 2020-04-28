<?php

	session_start();
	$apikey = $_SESSION['apikey'];

    $response = [
        'error' 	=> false,
		'errorMsg' 	=> '',
        'file'  	=> [],
    ];

    $acceptableTypes = ['jpg', 'jpeg', 'png', 'pdf', 'ppt', 'pptx'];

    $fileType = pathinfo($_FILES['presentation-file']['name'], PATHINFO_EXTENSION);

    if (!in_array($fileType, $acceptableTypes)) {
        $response['error'] = true;
		$response['errorMsg'] = "Invalid file type submitted. Only .jpg .jpeg .png .pdf .ppt and .pptx files are permitted.";
        echo json_encode($response);
        return;
    }

	$id = $_POST['post-id'];
    $file['title'] = $_POST['presentation-title'];
    $file['name'] = $_POST['presentation-name'] != "" ? $_POST['presentation-name'].'.'.$fileType : $_FILES['presentation-file']['name'];
    $file['purpose'] = $_POST['presentation-purpose'];
    $file['data'] = base64_encode(file_get_contents($_FILES['presentation-file']['tmp_name']));
    $file['type'] = $fileType;

	$data = array(
	    'action' => 'attachfiletolocation',
	    'apikey' => $apikey,
		'locationid' => $id,
		'filename' => $file['name'],
		'description' => $file['purpose'],
		'base64file' => $file['data'],
		'title' => $file['title'],
	);

	$ch = curl_init('https://reg.bookmein2.com/api/checkinapi.php');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	// execute
	$fileDetails = curl_exec($ch);

	// close the connection
	curl_close($ch);

	if (!$fileDetails) {
		$response['error'] = true;
		$response['errorMsg'] = 'Upload API failed';
		echo json_encode($response);
		return;
	}

	$fileDetails = json_decode($fileDetails);

	if (!isset($fileDetails->success)) {
		$response['error'] = true;
		$response['errorMsg'] = 'Profile API failed';
		echo json_encode($response);
		return;
	}

	if ($fileDetails->success == false) {
		$response['error'] = true;
		$response['errorMsg'] = 'Profile API failed';
		echo json_encode($response);
		return;
	}

    $response['file'] = $file;

    echo json_encode($response);
    return;
