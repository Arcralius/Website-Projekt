<!DOCTYPE HTML>
<html lang="en">
    <head>
        <?php
        include 'header.php';
        ?>
    </head>

    <body>
            <?php
            include 'navbar.php';
            echo '<main>';
            require_once 'GoogleAuthenticator.php';
            $ga = new PHPGangsta_GoogleAuthenticator();
            $username = $errorMsg = "";
            $success = true;

            if (empty($_POST["username"])) {
                $errorMsg .= "username is required.<br>";
                $success = false;
            } else if (!preg_match("/^[a-zA-Z0-9]{1,255}$/", $_POST["username"])) { //this regex will validate if the username only has alphanumeric chars
                $errorMsg .= "Username should only contain alphanumeric characters.<br>";
                //set the following the false so that the user inputs will not be added to database should it not meet the formatting requirements.
                $inputSuccess = false;
            } else {
                $formusername = sanitize_input($_POST["username"]);
            }


            //Check if username is empty

            if (empty($_POST["fa"])) {
                $errorMsg .= "2 FA Field is required<br>";
                $success = false;
            } else if (!preg_match("/^[0-9]{1,6}$/", $_POST["fa"])) { //this regex will validate if the username only has alphanumeric chars
                $errorMsg .= "2 FA Field should only contain numeric characters.<br>";
                //set the following the false so that the user inputs will not be added to database should it not meet the formatting requirements.
                $fa = NULL;
                $inputSuccess = false;
            } else {
                $fa = sanitize_input($_POST["fa"]);
            }

            authenticateUser();



            if ($success) {
                $checkResult = $ga->verifyCode($dbfa, $fa, 2);    // 2 = 2*30sec clock tolerance
                if ($checkResult) {
                    session_destroy();
                    session_start();
                    $_SESSION["role"] = $role;
                    $_SESSION["username"] = $username;
                    echo '<script>';
                    echo 'window.location.href = "account.php";';
                    echo '</script>';
                } else {
                    session_destroy();
                    session_start();
                    $_SESSION["username"] = $username;
                    echo '<script>';
                    echo 'createCookie("errorMsg", "2 FA does not match.", 1);';
                    echo 'window.location.href = "2faauth.php";';
                    echo '</script>';
                }
            } else {
                session_destroy();
                session_start();

                $_SESSION["username"] = $username;

                echo '<script>';
                echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                echo 'window.location.href = "2faauth.php";';
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
                global $errorMsg, $success, $formusername, $dbfa, $role, $username;
                $config = parse_ini_file("../../private/db-config.ini");
                $conn = new mysqli(
                    $config["servername"],
                    $config["username"],
                    $config["password"],
                    $config["dbname"]
                );
                // Check connection

                $formusername = mysqli_real_escape_string($conn, $formusername);

                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    // Prepare the statement:         
                    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
                    // Bind & execute the query statement:         
                    $stmt->bind_param("s", $formusername);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        // Note that email field is unique, so should only have
                        // one row in the result set.             
                        $row = $result->fetch_assoc();
                        $dbfa = $row["2fa"];
                        $role = $row["role"];
                        $username = $row["username"];
                        // Check if the password matches:
                    } else {
                        $errorMsg = "User not found.<br>";
                        $success = false;
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>
        </main>
        <?php include 'footer.php';?>
    </body>
</html>