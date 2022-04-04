<?php
include 'header.php';
include 'navbar.php';

$result = "";
$email = $errorMsg = "";
$success = true;

$oldpw = $_POST["old_password"];
getpw();

if (empty($_POST["old_password"])) {
    $errorMsg .= "Old Password field is required.<br>";
    $success = false;
} else if (empty($_POST["cfm_new_password"])) {
    $errorMsg .= "New Password and Comfirm New password field is required.<br>";
    $success = false;
}  else if (empty($_POST["new_password"])) {
    $errorMsg .= "New Password and Comfirm New password field is required.<br>";
    $success = false;
} else if ($_POST["cfm_new_password"] != $_POST["new_password"]){
    $errorMsg .= "Passwords do not match.<br>";
    $success = false;
}  else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $oldpw)) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
    $errorMsg .= "Invalid Password<br>";
    $success = false;
} else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $_POST["new_password"])) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
    $errorMsg .= "Minimum password length must be 8. We only accept alphanumeric characters and specific special characters: @,# and $<br>";
    $success = false;
} else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $_POST["cfm_new_password"])) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
    $errorMsg .= "Minimum password length must be 8. We only accept alphanumeric characters and specific special characters: @,# and $<br>";
    $success = false;
}   else {
    $password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
    $pwd_confirm = $_POST["cfm_new_password"];
    if (!password_verify($pwd_confirm, $password)) {
        $pwd_confirm = "";
        $errorMsg .= "Passwords are not the same.<br>";
        $success = false;
    } else {
        $pwd_confirm = password_hash($_POST["cfm_password"], PASSWORD_DEFAULT);
    }
}

if (!password_verify($oldpw, $hashedpw))
{
    $errorMsg .= "Old password is invalid.<br>";
    $success = false;
}

if ($success) {
    updateuserpw();
    if($success) {
        echo '<script>';
        echo 'createCookie("succmessage", "Edited password!", 1);';
        echo 'window.location.href = "account.php";';
        echo '</script>';
    }
    else {
        echo '<script>';
        echo 'createCookie("errorMsg", "Username or Email has been taken.", 1);';
        echo 'window.location.href = "account.php";';
        echo '</script>';
    }
} else {
    echo '<script>';
    echo 'createCookie("errorMsg", "'.$errorMsg.'", 1);';
    echo 'window.location.href = "account.php";';
    echo '</script>';
}

function updateuserpw()
{
    global $errorMsg, $success, $password;
    $config = parse_ini_file("../../private/db-config.ini");
    $conn = new mysqli(
        $config["servername"],
        $config["username"],
        $config["password"],
        $config["dbname"]
    );
    $password = mysqli_real_escape_string($conn, $password);
    // Check connection     
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // Prepare the statement:         
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?;");
        //Bind & execute the query statement:         
        $stmt->bind_param("si", $password, $_SESSION['id']);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
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
    global $hashedpw, $errorMsg, $success, $passwordold;
    
    $config = parse_ini_file("../../private/db-config.ini");
    $conn = new mysqli(
        $config["servername"],
        $config["username"],
        $config["password"],
        $config["dbname"]
    );
    $passwordold = mysqli_real_escape_string($conn, $_POST["old_password"]);
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
?>