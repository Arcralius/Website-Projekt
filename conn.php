<?php
$config = parse_ini_file("../../private/db-config.ini");
	// Create connection
	$config = parse_ini_file("../../private/db-config.ini");
	$conn = new mysqli($config["servername"], $config["username"],
		$config["password"], $config["dbname"]);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
