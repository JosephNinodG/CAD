<?php

	// start session
	session_start();

	// unset session vars
	session_unset();

	// destroy session
	session_destroy();

	// reset current session data
	$_SESSION = array();

	// redirect back to login
	header("Location: /CAD/index.php");
	exit;

?>
