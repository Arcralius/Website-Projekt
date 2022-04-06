<head>
    <?php
    include 'header.php';
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    include 'navbar.php';
    $result = "";
    $email = $errorMsg = "";
    $success = true;


    if (empty($_POST["username"])) {
        $errorMsg .= "Username is required.<br>";
        $success = false;
    } else if (!preg_match("/^[a-zA-Z0-9]{1,255}$/", $_POST["username"])) {
        $errorMsg .= "Username should only contain alphanumeric characters.<br>";
        $success = false;
    } else {
        $username = sanitize_input($_POST["username"]);
    }

    //Check if email is empty
    if (empty($_POST["email"])) {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    } else if (!preg_match("/[a-zA-Z0-9_\-]+@([a-zA-Z_\-])+[.]+[a-zA-Z]{2,4}/", $_POST["email"])) {
        $errorMsg .= "Invalid email format.<br>";
        $success = false;
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

    if (empty($_POST["password"])) {
        $errorMsg .= "Password and Comfirm password field is required.<br>";
        $success = false;
    } else if (empty($_POST["cfm_password"])) {
        $errorMsg .= "Password and Comfirm password field is required.<br>";
        $success = false;
    }  else if ($_POST["cfm_password"] != $_POST["password"]){
        $errorMsg .= "Passwords do not match.<br>";
        $success = false;
    }  else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $_POST["password"])) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
        $errorMsg .= "Minimum password length must be 8. We only accept alphanumeric characters and specific special characters: @,# and $<br>";
        $success = false;
    } else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $_POST["cfm_password"])) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
        $errorMsg .= "Minimum password length must be 8. We only accept alphanumeric characters and specific special characters: @,# and $<br>";
        $success = false;
    } else {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $pwd_confirm = $_POST["cfm_password"];
        if (!password_verify($pwd_confirm, $password)) {
            $pwd_confirm = "";
            $errorMsg .= "Passwords are not the same.<br>";
            $success = false;
        } else {
            $pwd_confirm = password_hash($_POST["cfm_password"], PASSWORD_DEFAULT);
        }
    }



    if ($success) {
        saveMemberToDB();
        if($success) {
            echo '<script>';
            echo 'createCookie("succmessage", "Sign up success!", 1);';
            echo 'window.location.href = "signin.php";';
            echo '</script>';
        }
        else {
            echo '<script>';
            echo 'createCookie("errorMsg", "Username or Email has been taken.", 1);';
            echo 'window.location.href = "signup.php";';
            echo '</script>';
        }

    } else {
        echo '<script>';
        echo 'createCookie("errorMsg", "'.$errorMsg.'", 1);';
        echo 'window.location.href = "signup.php";';
        echo '</script>';
    }

    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function saveMemberToDB()
    {
        global $errorMsg, $success, $fname, $lname, $username, $password, $email;
        
        $config = parse_ini_file("../../private/db-config.ini");
        $conn = new mysqli($config["servername"], $config["username"],
            $config["password"], $config["dbname"]);

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
            $role = "U";
            // Prepare the statement:         
            $stmt = $conn->prepare("INSERT INTO users (username, fname, lname, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            //Bind & execute the query statement:         
            $stmt->bind_param("ssssss", $username, $fname, $lname, $email, $password, $role);
            if (!$stmt->execute())         
            {             
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;         
            }         
            $stmt->close();
        }
        $conn->close();
    }
    ?>
</body>