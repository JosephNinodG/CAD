<?php
	// default response
    $response = [
        'error' 	=> false,
		'errorMsg' 	=> '',
        'file'  	=> [],
    ];

	// array of acceptable image types
    $acceptableTypes = ['jpg', 'jpeg', 'png'];

	// get file type of upload
    $fileType = pathinfo($_FILES['cover-image-file']['name'], PATHINFO_EXTENSION);

	// if file type not in array of accepted types, error out
    if (!in_array(strtolower($fileType), $acceptableTypes)) {
        $response['error'] = true;
		$response['errorMsg'] = "Invalid file type submitted. Only .jpg .jpeg and .png files are permitted.";
        echo json_encode($response);
        return;
    }

	// set file data
    $file['data'] = base64_encode(file_get_contents($_FILES['cover-image-file']['tmp_name']));
	$file['name'] = $_FILES['cover-image-file']['name'];

    $response['file'] = $file;

	// return response
    echo json_encode($response);
    return;
