<?php
	//temporary hardcode session role as admin for all the admin pages
    if (!isset($_SESSION['role'])) 
    {
		
        header("Location: /Website-Projekt/signin.php");
    }
	else 
	{
		if ($_SESSION['role'] =! 'A')
		{
			header("Location: /Website-Projekt/signin.php");
		}
		else
		{
			$_SESSION['role'] = 'A';
		}
	}
?>