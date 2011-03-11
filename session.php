<?php
session_start();
$id_client = $_SESSION['id_client'];
$client_table = $_SESSION['client_table'];
	if(!$id_client)
	{
		header("location: login.php");
		exit;
	}

?>