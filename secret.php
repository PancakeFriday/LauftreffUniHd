<?php

	require_once(__DIR__.'/VIWebFramework/VIDatabase.php');

	$host = 'localhost';
	$user = 'lauftreffunihd';
	$password = '01754532207';
	$con_database = 'lauftreffunihd';

	$database = new VIDatabase($host, $user, $password, $con_database);

	if($database === false)
	{
		die('Connect Error (' . $database->mysqli->connect_errno . ') ' . $database->mysqli->connect_error);
	}

?>