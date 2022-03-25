<?php
include 'header.php';
include 'navbar.php';
$result = "";
$email = $errorMsg = "";
$success = true;

getpw();

if (empty($_POST["password"])) {
    $errorMsg .= "Password field is required.<br>";
    $success = false;
} else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $_POST["password"])) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
    $errorMsg .= "Minimum password length must be 8. We only accept alphanumeric characters and specific special characters: @,# and $<br>";
    $success = false;
} else {   
    if (!password_verify($password, $hashedpw)) {

        $errorMsg .= "Wrong password<br>";
        $success = false;
    }
}

if ($success) {
    deluser();
    if ($success) {
        session_destroy();
        echo '<script>';
        echo 'createCookie("succmessage", "Delete success!", 1);';
        echo 'window.location.href = "signin.php";';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'createCookie("errorMsg", "An error has occoured.", 1);';
        echo 'window.location.href = "account.php";';
        echo '</script>';
    }
} else {
    echo '<script>';
    echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
    echo 'window.location.href = "account.php";';
    echo '</script>';
}

function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getpw()
{
    global $hashedpw, $errorMsg, $success, $password;
    

    $config = parse_ini_file("../../private/db-config.ini");
    $conn = new mysqli(
        $config["servername"],
        $config["username"],
        $config["password"],
        $config["dbname"]
    );

    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $id = mysqli_real_escape_string($conn, $_SESSION['id']);

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {           
            $row = $result->fetch_assoc();
            $hashedpw = $row["password"];
        }

        $stmt->close();
    }
    $conn->close();
}

function deluser()
{
    global $errorMsg, $success;

    $config = parse_ini_file("../../private/db-config.ini");
    $conn = new mysqli(
        $config["servername"],
        $config["username"],
        $config["password"],
        $config["dbname"]
    );

    $id = mysqli_real_escape_string($conn, $_SESSION['id']);
    
    // Check connection     
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {

        // Prepare the statement:         
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?;");
        //Bind & execute the query statement:         
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }

        $stmt->close();
    }
    $conn->close();
}
