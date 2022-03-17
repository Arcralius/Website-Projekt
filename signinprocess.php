<head>
    <?php
    include 'header.php';
    ?>
</head>

<body>

    <?php
    include 'navbar.php';

    $username = $errorMsg = "";
    $success = true;

    //Check if username is empty
    if (empty($_POST["username"])) {
        $errorMsg .= "username is required.<br>";
        $success = false;
    } else if (!preg_match("/^[a-zA-Z0-9]{1,255}$/", $_POST["username"])) { //this regex will validate if the username only has alphanumeric chars
        $errorMsg .= "Username should only contain alphanumeric characters.<br>";
        //set the following the false so that the user inputs will not be added to database should it not meet the formatting requirements.
        $inputSuccess = false;
    } else {
        $username = sanitize_input($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $errorMsg .= "Password and Comfirm password field is required.<br>";
        $success = false;
    } else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $_POST["password"])) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
        $errorMsg .= "Minimum password length must be 8. We only accept alphanumeric characters and specific special characters: @,# and $<br>";
        $success = false;
    } else {
        authenticateUser();
    }


    if ($success) {
        session_destroy();
        session_start();
        $_SESSION["role"] = $role;
        $_SESSION["username"] = $username;
        
        echo '<script>';
        echo 'window.location.href = "/Website-Projekt/account.php";';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'createCookie("errorMsg", "'.$errorMsg.'", 1);';
        echo 'window.location.href = "/Website-Projekt/signin.php";';
        echo '</script>';
    }

    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function authenticateUser()
    {
        global $errorMsg, $success, $fname, $lname, $username, $password_hashed, $role, $username;
        $servername = "localhost";
        $dbusername = "arcralius";
        $dbpassword = "password";
        $dbname = "ict1004_assignment";


        // Create connection
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        // Check connection
        if ($conn->connect_error) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        } else {
            // Prepare the statement:         
            $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
            // Bind & execute the query statement:         
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Note that email field is unique, so should only have
                // one row in the result set.             
                $row = $result->fetch_assoc();
                $fname = $row["fname"];
                $lname = $row["lname"];
                $role = $row["role"];
                $username = $row["username"];
                $password_hashed = $row["password"];
                // Check if the password matches:
                if (!password_verify($_POST["password"], $password_hashed)) {

                    // Don't be too specific with the error message - hackers don't                 

                    // need to know which one they got right or wrong. :)                 

                    $errorMsg = "Email not found or password doesn't match.<br>";
                    $success = false;
                }
            } else {
                $errorMsg = "Email not found or password doesn't match.<br>";
                $success = false;
            }
            $stmt->close();
        }
        $conn->close();
    }
    ?>
</body>