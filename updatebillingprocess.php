<?php
include 'header.php';
include 'navbar.php';

$errorMsg = "";
$success = true;
$userID = $_SESSION['id'];
$address = $_POST["address"];

if (empty($_POST["fullname"])) {
    $errorMsg .= "Fullname is required.<br>";
    $success = false;
} else if (!preg_match("/^[a-zA-Z0-9]{1,255}$/", $_POST["fullname"])) {
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

if (empty($_POST["expiration"])) {
    $errorMsg .= "Card expiration date is required.<br>";
    $success = false;
} else if (!preg_match("/^[0-9]+-+[0-9]*$/", $_POST["expiration"])) {
    $errorMsg .= "Card expiration date should only contain numbers.<br>";
    $success = false;
} else {
    $expiration = sanitize_input($_POST["expiration"]);
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
    updatebilling();
    if ($success) 
    {
        echo '<script>';
        echo 'createCookie("succmessage", "Edit success!", 1);';
        echo 'window.location.href = "account.php";';
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

function updatebilling()
{
    global $userID, $errorMsg, $success, $fullname, $cardno, $cvv, $expiration, $address;
     
    
    // SQL Statements
    $selectsql = "SELECT * FROM payment_details WHERE user_id=?";
    $insertsql = "INSERT INTO payment_details (user_id, name, card_number, CVC, expiration, address) VALUES (?, ?, ?, ?, ?, ?)";
    $updatesql = "UPDATE payment_details SET name = ?, card_number = ?, CVC = ?, expiration = ?, address = ? WHERE user_id = ?;";
    
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
        $stmt = $conn->prepare($selectsql);
        // Bind & execute the query statement:         
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $number_of_rows = $result->num_rows  ;
        $stmt->close();
                   
        if ($number_of_rows > 0)
        {
            $stmt = $conn->prepare($updatesql);
            $stmt->bind_param("sssssi", $fullname, $cardno, $cvv, $expiration, $address, $userID);
            
            if (!$stmt->execute()) 
            {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }
            $stmt->close();
            
        }
        else
        {
            $stmt = $conn->prepare($insertsql);
            $stmt->bind_param("isssss", $userID, $fullname, $cardno, $cvv, $expiration, $address);
            
            if (!$stmt->execute()) 
            {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                echo '<h3>' . $errorMsg .'</h3>';
                $success = false;
            }
            $stmt->close();
        }
    }
}