<?php
include 'header.php';
include 'navbar.php';
$result = "";
$email = $errorMsg = "";
$success = true;




if (empty($_POST["username"])) {
    $errorMsg .= "Username is required.<br>";
    $success = false;
} else if (!preg_match("/^[a-zA-Z0-9]{1,255}$/", $_POST["username"])) {
    $errorMsg .= "Username should only contain alphanumeric characters.<br>";
    $inputSuccess = false;
} else {
    $username = sanitize_input($_POST["username"]);
}

//Check if email is empty
if (empty($_POST["email"])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else if (!preg_match("/[a-zA-Z0-9_\-]+@([a-zA-Z_\-])+[.]+[a-zA-Z]{2,4}/", $_POST["email"])) {
    $errorMsg .= "Invalid email format.<br>";
    $inputSuccess = false;
} else {
    $email = sanitize_input($_POST["email"]);
    // Additional check to make sure e-mail address is well-formed.     
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email format.<br>";
        $success = false;
    }
}

if (empty($_POST["fname"])) {
    $fname = "";
} else if (!preg_match("/^([a-zA-Z ])+$/", $_POST["fname"])) {
    $errorMsg .= "Invalid first Name.<br>";
    $success = false;
} else {
    $fname = sanitize_input($_POST["fname"]);
}

//Check if last name field is empty
if (empty($_POST["lname"])) {
    $errorMsg .= "Last name field is required.<br>";
    $success = false;
} else if (!preg_match("/^([a-zA-Z ])+$/", $_POST["lname"])) {
    $errorMsg .= "Invalid last name.<br>";
    $success = false;
} else {
    $lname = sanitize_input($_POST["lname"]);
}

if ($success) {
    updateuser();
    if ($success) {
        $_SESSION['username'] = $username;
        echo '<script>';
        echo 'createCookie("succmessage", "Edit success!", 1);';
        echo 'window.location.href = "account.php";';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'createCookie("errorMsg", "Username or Email has been taken.", 1);';
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

function updateuser()
{
    global $errorMsg, $success, $fname, $lname, $username, $password, $email;

    $config = parse_ini_file("../../private/db-config.ini");
    $conn = new mysqli(
        $config["servername"],
        $config["username"],
        $config["password"],
        $config["dbname"]
    );

    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $password = mysqli_real_escape_string($conn, $password);

    // Check connection     
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
 
        // Prepare the statement:         
        $stmt = $conn->prepare("UPDATE users SET username = ? , fname = ?, lname = ?, email = ? WHERE user_id = ?;");
        //Bind & execute the query statement:         
        $stmt->bind_param("ssssi", $username, $fname, $lname, $email, $_SESSION['id']);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}
