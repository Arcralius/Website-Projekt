<?php
	//temporary hardcode session role as admin for all the admin pages
	$_SESSION["role"] = "A";
	if (isset($_SESSION["role"]) AND $_SESSION["role"] == "A") {

	}
	else{
		//header('location:signin.php');
		echo '<script>';
        echo 'window.location.href = "signin.php";';
        echo '</script>';
	}
?>