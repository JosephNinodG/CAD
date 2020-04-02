<?php
    $response = [
        'error' => false,
        'file'  => [],
    ];

    $acceptableTypes = ['jpg', 'png'];

    $fileType = pathinfo($_FILES['cover-image-file']['name'], PATHINFO_EXTENSION);

    if (!in_array($fileType, $acceptableTypes)) {
        $response['error'] = true;
        echo json_encode($response);
        return;
    }

    $file['data'] = base64_encode(file_get_contents($_FILES['cover-image-file']['tmp_name']));
	$file['name'] = $_FILES['cover-image-file']['name'];

    $response['file'] = $file;

    echo json_encode($response);
    return;
