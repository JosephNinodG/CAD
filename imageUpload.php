<?php
    $response = [
        'error' 	=> false,
		'errorMsg' 	=> '',
        'file'  	=> [],
    ];

    $acceptableTypes = ['jpg', 'jpeg', 'png'];

    $fileType = pathinfo($_FILES['cover-image-file']['name'], PATHINFO_EXTENSION);

    if (!in_array($fileType, $acceptableTypes)) {
        $response['error'] = true;
		$response['errorMsg'] = "Invalid file type submitted. Only .jpg .jpeg and .png files are permitted.";
        echo json_encode($response);
        return;
    }

    $file['data'] = base64_encode(file_get_contents($_FILES['cover-image-file']['tmp_name']));
	$file['name'] = $_FILES['cover-image-file']['name'];

    $response['file'] = $file;

    echo json_encode($response);
    return;
