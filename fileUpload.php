<?php
    $response = [
        'error' 	=> false,
		'errorMsg' 	=> '',
        'file'  	=> [],
    ];

    $acceptableTypes = ['jpg', 'png', 'pdf', 'ppt', 'pptx'];

    $fileType = pathinfo($_FILES['presentation-file']['name'], PATHINFO_EXTENSION);

    if (!in_array($fileType, $acceptableTypes)) {
        $response['error'] = true;
		$response['errorMsg'] = "Invalid file type submitted. Only .jpg .png .pdf .ppt and .pptx files are permitted.";
        echo json_encode($response);
        return;
    }

    $file['title'] = $_POST['presentation-title'];
    $file['name'] = $_POST['presentation-name'] != "" ? $_POST['presentation-name'] : $_FILES['presentation-file']['name'];
    $file['purpose'] = $_POST['presentation-purpose'];
    $file['data'] = base64_encode(file_get_contents($_FILES['presentation-file']['tmp_name']));
    $file['type'] = $fileType;

    $response['file'] = $file;

    echo json_encode($response);
    return;
