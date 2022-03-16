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
    } else {
        $username = sanitize_input($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $errorMsg .= "Password and Comfirm password field is required.<br>";
        $success = false;
    } else {
        authenticateUser();
    }


    if ($success) {
        echo "<main class='container' id='process_login'>";
        echo "<hr/>";
        echo "<h1>Your login is successful!</h1>";
        echo "<h4>Welcome back, " . $fname . " " . $lname . "</h4>";
        echo '</form>';
        echo "</main>";
    } else {
        echo "<main class='container' id='process_login'>";
        echo "<hr/>";
        echo "<h1>Oops!</h1>";
        echo "<h4>The following input errors were detected:</h4>";
        echo "<p>" . $errorMsg . "</p>";
        echo '<form action="signin.php" method="post">';
        echo '<button class="btn btn-danger" type="submit">Return to Login</button>';
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

    function authenticateUser()
    {
        global $errorMsg, $success, $fname, $lname, $username, $password_hashed;
        $servername = "localhost";
        $dbusername = "arcralius";
        $dbpassword = "password";
        $dbname = "worldofpetsv2";


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
                $password_hashed = $row["password"];
                // Check if the password matches:
                if ($password_hashed != $_POST["password"]) {

                    // Don't be too specific with the error message - hackers don't                 

                    // need to know which one they got right or wrong. :)                 

                    $errorMsg = "Email not found or password doesn't match...";
                    $success = false;
                }
            } else {
                $errorMsg = "Email not found or password doesn't match...";
                $success = false;
            }
            $stmt->close();
        }
        $conn->close();
    }
    ?>
</body>