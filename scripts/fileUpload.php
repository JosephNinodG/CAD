<?php

	// start session
	session_start();

	// get apikey
	$apikey = $_SESSION['apikey'];

	// default response
    $response = [
        'error' 	=> false,
		'errorMsg' 	=> '',
        'file'  	=> [],
    ];

	// list of acceptable file types (could be db driven)
    $acceptableTypes = ['jpg', 'jpeg', 'png', 'pdf', 'ppt', 'pptx'];

	// get filytype of uploaded file
    $fileType = pathinfo($_FILES['presentation-file']['name'], PATHINFO_EXTENSION);

	// if filetype not in the array of accepted types, error out
    if (!in_array(strtolower($fileType), $acceptableTypes)) {
        $response['error'] = true;
		$response['errorMsg'] = "Invalid file type submitted. Only .jpg .jpeg .png .pdf .ppt and .pptx files are permitted.";
        echo json_encode($response);
        return;
    }

	// Set data fields
	$id = $_POST['post-id'];
    $file['title'] = $_POST['presentation-title'];
    $file['name'] = $_POST['presentation-name'] != "" ? $_POST['presentation-name'].'.'.$fileType : $_FILES['presentation-file']['name'];
    $file['purpose'] = $_POST['presentation-purpose'];
    $file['data'] = base64_encode(file_get_contents($_FILES['presentation-file']['tmp_name']));
    $file['type'] = $fileType;

	// Add data to array to be curled
	$data = array(
	    'action' => 'attachfiletolocation',
	    'apikey' => $apikey,
		'locationid' => $id,
		'filename' => $file['name'],
		'description' => $file['purpose'],
		'base64file' => $file['data'],
		'title' => $file['title'],
	);

	// Attempt curl
	$ch = curl_init('https://reg.bookmein2.com/api/checkinapi.php');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	// execute
	$fileDetails = curl_exec($ch);

	// close the connection
	curl_close($ch);

	// If no result, error out
	if (!$fileDetails) {
		$response['error'] = true;
		$response['errorMsg'] = 'Upload API failed';
		echo json_encode($response);
		return;
	}

	// Decode result to see response
	$fileDetails = json_decode($fileDetails);

	// If success isn't set, error out
	if (!isset($fileDetails->success)) {
		$response['error'] = true;
		$response['errorMsg'] = 'Upload API failed';
		echo json_encode($response);
		return;
	}

	// If success is false, error out
	if ($fileDetails->success == false) {
		$response['error'] = true;
		$response['errorMsg'] = 'Upload API failed';
		echo json_encode($response);
		return;
	}

	// Add file to response
    $response['file'] = $file;

	// Return response
    echo json_encode($response);
    return;
