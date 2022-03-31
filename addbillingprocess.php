<?php

include 'header.php';
include 'navbar.php';

$errorMsg = "";
$success = true;
$userID = $_SESSION['id'];
$address = $_POST["address"];

$date = "01";
$year = "20";
$x = explode("-",$_POST["expiration"]); // split the month and year by date 
$month = $x[0];
$expiration = $year . $x[1] . "-" . $month . "-" . $date ;


if (empty($_POST["fullname"])) {
    $errorMsg .= "Fullname is required.<br>";
    $success = false;
} else if (!preg_match("/^[a-zA-Z0-9 ]{1,255}$/", $_POST["fullname"])) {
    $errorMsg .= "Fullname should only contain alphanumeric characters.<br>";
    $success = false;
} else {
    $fullname = sanitize_input($_POST["fullname"]);
}

if (empty($_POST["cardno"])) {
    $errorMsg .= "Card Number is required.<br>";
    $success = false;
} else if (!preg_match("/^[0-9 ]*$/", $_POST["cardno"])) {
    $errorMsg .= "Card Number should only contain numbers.<br>";
    $success = false;
} else {
    $cardno = sanitize_input($_POST["cardno"]);
}

if (empty($_POST["cvv"])) {
    $errorMsg .= "CVV is required.<br>";
    $success = false;
} else if (!preg_match("/^[0-9]*$/", $_POST["cvv"])) {
    $errorMsg .= "CVV should only contain numbers.<br>";
    $success = false;
} else {
    $cvv = sanitize_input($_POST["cvv"]);
}

if (empty($expiration)) {
    $errorMsg .= "Card expiration date is required.<br>";
    $success = false;
} else if (!preg_match("/^[0-9]+-+[0-9]+-+[0-9]*$/", $expiration)) {
    $errorMsg .= "Card expiration date should only contain numbers.<br>";
    $success = false;
} else {
    $expiration = sanitize_input($expiration);
}

/*
if (empty($_POST["address"])) {
    $errorMsg .= "Address is required.<br>";
    $success = false;
} else if (!preg_match("/^\s*\S+(?:\s+\S+){2}/", $_POST["address"])) {
    $errorMsg .= "Invalid Address.<br>";
    $success = false;
} else {
    $address = sanitize_input($_POST["address"]);
}

*/

if ($success) {
    addbilling();
    if ($success) 
    {
        echo '<script>';
        echo 'createCookie("succmessage", "Card added successfully!", 1);';
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

function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function addbilling()
{
    global $userID, $paymentID, $errorMsg, $success, $fullname, $cardno, $cvv, $expiration, $address;
     
    // SQL Statements
    $insertsql = "INSERT INTO payment_details (user_id, name, card_number, CVC, expiration, address) VALUES (?, ?, ?, ?, ?, ?)";
    
    $config = parse_ini_file("../../private/db-config.ini");
    $conn = new mysqli(
            $config["servername"],
            $config["username"],
            $config["password"],
            $config["dbname"]
    );
    
    
    $fullname = mysqli_real_escape_string($conn, $fullname);
    $cardno = mysqli_real_escape_string($conn, $cardno);
    $cvv = mysqli_real_escape_string($conn, $cvv);
    $expiration = mysqli_real_escape_string($conn, $expiration);
    $address = mysqli_real_escape_string($conn, $address);
   
    
    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // Prepare the statement:         
        $stmt = $conn->prepare($insertsql);
        $stmt->bind_param("isssss", $userID, $fullname, $cardno, $cvv, $expiration, $address);

        
                   
        if (!$stmt->execute()) 
        {
            if ($stmt->errno === 1292)
            {
                $errorMsg = "Invalid date! Please key in the expiration date on your card";
                $success = false;
            }
            else
            {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }
        }
        $stmt->close();

    }
}