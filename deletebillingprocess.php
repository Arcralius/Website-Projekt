<?php

include 'header.php';
include 'navbar.php';

$errorMsg = "";
$success = true;
$userID = $_SESSION['id'];
$paymentID = $_POST["paymentid"];

if ($success) {
    deletebilling();
    if ($success) 
    {
        echo '<script>';
        echo 'createCookie("succmessage", "Delete success!", 1);';
        echo 'window.location.href = "billinginfo.php";';
        echo '</script>';
    }
    else
    {
        echo '<script>';
        echo 'createCookie("errorMsg", "' . $errorMsg . '",1);';
        echo 'window.location.href = "billinginfo.php";';
        echo '</script>';
    }
} else {
    echo '<script>';
    echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
    echo 'window.location.href = "billinginfo.php";';
    echo '</script>';
}

function deletebilling()
{
    global $userID, $paymentID;
    
    $config = parse_ini_file("../../private/db-config.ini");
    $conn = new mysqli(
            $config["servername"],
            $config["username"],
            $config["password"],
            $config["dbname"]
    );
    
    $deletesql = "DELETE FROM payment_details WHERE user_id = ? AND payment_id = ? ;";
    
    
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } 
    else {
        // Prepare the statement:         
        $stmt = $conn->prepare($deletesql);
        $stmt->bind_param("ii", $userID, $paymentID);
        $stmt->execute();
        $result = $stmt->get_result();
        $number_of_rows = $result->num_rows;
        $stmt->close();

        if (!$stmt->execute())
        {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
  
        }
}
