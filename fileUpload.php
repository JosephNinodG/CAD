<?php
     echo json_encode(base64_encode(file_get_contents($_FILES['presentation-file']['tmp_name']))); 
?>
