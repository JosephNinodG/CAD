<?php

	session_start();
	session_unset();
	session_destroy();
	$_SESSION = array();

	header("Location: /CAD/index.php");
	exit;

?>
