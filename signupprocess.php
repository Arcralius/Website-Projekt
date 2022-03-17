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
    } else if (!preg_match("/^[a-zA-Z0-9]{1,255}$/", $_POST["username"])) { //this regex will validate if the username only has alphanumeric chars
        $errorMsg .= "Invalid Username format. Username should only contain alphanumeric characters.<br>";
        //set the following the false so that the user inputs will not be added to database should it not meet the formatting requirements.
        $inputSuccess = false;
    } else {
        $username = sanitize_input($_POST["username"]);
    }

    //Check if email is empty
    if (empty($_POST["email"])) {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    } else if (!preg_match("/[a-zA-Z0-9_\-]+@([a-zA-Z_\-])+[.]+[a-zA-Z]{2,4}/", $_POST["email"])) { //this regex will validate if the user email matches the format of an email i.e example@email.com
        $errorMsg .= "Invalid email format.";
        $inputSuccess = false;
    } else {
        $email = sanitize_input($_POST["email"]);
        // Additional check to make sure e-mail address is well-formed.     
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.";
            $success = false;
        }
    }

    if (empty($_POST["fname"])) {
        $fname = "";
    } else if (!preg_match("/^([a-zA-Z ])+$/", $_POST["fname"])) {
        $errorMsg .= "Invalid last Name.<br>";
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
        $success = true;
    }

    if (empty($_POST["password"])) {
        $errorMsg .= "Password and Comfirm password field is required.<br>";
        $success = false;
    } else if (empty($_POST["cfm_password"])) {
        $errorMsg .= "Password and Comfirm password field is required.<br>";
        $success = false;
    } else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", ($_POST["password"]))) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
        $errorMsg .= "Passwords must be of minimum length 8 characters. We only accept alphanumeric characters, spaces and select symbols: @,# and $..<br>";
        $success = false;
    } else if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", ($_POST["cfm_password"]))) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
        $errorMsg .= "Passwords must be of minimum length 8 characters. We only accept alphanumeric characters, spaces and select symbols: @,# and $..<br>";
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
            $success = true;
        }
    }

    saveMemberToDB();

    if ($success) {
        echo "<main class='container' id='process_register'>";
        echo "<hr/>";
        echo "<h1>Your registration successful!</h1>";
        echo "<h4>Thank you for signing up, " . $fname . " " . $lname . "</h4>";
        echo '<form action="signup.php" method="post">';
        echo '<button class="btn btn-success" type="submit">Log-in</button>';
        echo '</form>';
        echo "</main>";

        echo "<h1>$result</h1>";
    } else {
        echo "<main class='container' id='process_register'>";
        echo "<hr/>";
        echo "<h1>Oops!</h1>";
        echo "<h4>The following input errors were detected:</h4>";
        echo "<p>" . $errorMsg . "</p>";
        echo '<form action="signup.php" method="post">';
        echo '<button class="btn btn-danger" type="submit">Return to Sign Up</button>';
        echo '</form>';
        echo "</main>";
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
        $servername = "localhost";
        $dbusername = "arcralius";
        $dbpassword = "password";
        $dbname = "worldofpetsv2";

        // Create database connection.
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

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
            $stmt = $conn->prepare("INSERT INTO users (username, fname, lname, email, password) VALUES (?, ?, ?, ?, ?)");
            //Bind & execute the query statement:         
            $stmt->bind_param("sssss", $username, $fname, $lname, $email, $password);
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