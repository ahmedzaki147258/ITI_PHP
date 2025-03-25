<?php

session_start();
if (isset($_SESSION['name'])) {
	$_SESSION = array();
	session_destroy();
	header("location:loginForm.php");
	exit;
}
