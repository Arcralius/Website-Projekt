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
    
    $email = $errorMsg = ""; 
    $success = true;


    if (empty($_POST["username"]))
    {
        $errorMsg .= "Username is required.<br>";     
        $success = false; 
    }
    else
    {
        $username = sanitize_input($_POST["username"]);
    }

    //Check if email is empty
    if (empty($_POST["email"])) 
    {     
        $errorMsg .= "Email is required.<br>";     
        $success = false; 
    }
    else
    {
        $email = sanitize_input($_POST["email"]);
        // Additional check to make sure e-mail address is well-formed.     
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {         
            $errorMsg .= "Invalid email format.";         
            $success = false;    
        }
    }

    if (empty($_POST["fname"]))
    {
        $fname = "";
    }
    else
    {
        $fname = sanitize_input($_POST["fname"]);
    }
    
    //Check if last name field is empty
    if (empty($_POST["lname"]))
    {
        $errorMsg .= "Last name field is required.<br>";     
        $success = false;
    }
    else 
    {
        $lname = sanitize_input($_POST["lname"]);
        $success = true;
    }

    if (empty($_POST["password"]))
    {
        $errorMsg .= "Password and Comfirm password field is required.<br>";     
        $success = false; 

    }
    else if (empty($_POST["cfm_password"]))
    {
        $errorMsg .= "Password and Comfirm password field is required.<br>";     
        $success = false; 

    }
    else
    {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $pwd_confirm = $_POST["cfm_password"];
        if (!password_verify($pwd_confirm, $password))
        {
            $pwd_confirm = "";
            $errorMsg .= "Passwords are not the same.<br>";
            $success = false;
        }
        else 
        {
            $pwd_confirm = password_hash($_POST["cfm_password"], PASSWORD_DEFAULT);
            $success = true; 
        }

    }
    
    if ($success)
    {
        echo "<main class='container' id='process_register'>";
        echo "<hr/>";
        echo "<h1>Your registration successful!</h1>";
        echo "<h4>Thank you for signing up, " . $fname . " " . $lname . "</h4>";
        echo '<form action="signup.php" method="post">';
        echo '<button class="btn btn-success" type="submit">Log-in</button>';
        echo '</form>';
        echo "</main>";
        saveMemberToDB();
    }
    else
    {
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
        
        // Check connection     
        if ($conn->connect_error)     
        {         
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        }     
        else     
        {
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



