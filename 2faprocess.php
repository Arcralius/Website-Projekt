<!DOCTYPE HTML>
<html lang="en">
<main>

    <head>

        <?php
        require_once 'GoogleAuthenticator.php';
        include 'header.php';
        ?>
    </head>

    <body>

        <?php
        include 'navbar.php';
        $result = "";
        $email = $errorMsg = "";
        $success = true;
        $ga = new PHPGangsta_GoogleAuthenticator();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl('Petshop', $secret);



        if (!isset($_SESSION['username'])) {
            header("Location: /Website-Projekt/signin.php");
        } else {
            $username = $_SESSION['username'];
        }

        takeinfo();

        if ($_POST["fa"] == "No") {
            remove2fa();
            echo '<script>';
            echo 'window.location.href = "2fa.php";';
            echo '</script>';
        } else if ($_POST["fa"] == "Yes") {
            if ($fa != NULL)
            {
                echo '<script>';
                echo 'createCookie("errorMsg", "2FA Already set!", 1);';
                echo 'window.location.href = "2fa.php";';
                echo '</script>';
            }
            else
            {
                add2fa();
            }
            
        } else {
            echo '<script>';
            echo 'createCookie("errorMsg", "An error has occoured please try again later.", 1);';
            echo 'window.location.href = "2fa.php";';
            echo '</script>';
        }
        ?>
        
        <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->
            <a class="nav-link active ms-0" href="/Website-Projekt/account.php">Profile</a>
            <!-- <a class="nav-link" href="https://www.bootdey.com/snippets/view/bs5-profile-billing-page" target="__blank">Billing</a> -->
            <a class="nav-link" href="/Website-Projekt/2fa.php" target="__blank">Security</a>

            <hr class="mt-0 mb-4">
            <!-- Account details card-->
            <div class="card mb-4">

                <div class="card-header">
                    <h1>Enable 2 Code</h1>
                </div>
                <div class="card text-center">
                    <div class="card-body">
                        <?php
                        echo "<img src=" . $qrCodeUrl . " alt='2fa code' style='align-self: center;'></img>";
                        ?>
                    </div>
                    <p>Please scan this QR code with an authenticator app.</p>
                </div>
            </div>
            <div>
                <p id="succmessage">
                </p>
                <p id="errormsg">
                </p>
            </div>
        </div>

        <?php
        function takeinfo()
        {
            global $errorMsg, $success, $fname, $lname, $password_hashed, $role, $username, $email, $fa;
            $config = parse_ini_file("../../private/db-config.ini");
            $conn = new mysqli(
                $config["servername"],
                $config["username"],
                $config["password"],
                $config["dbname"]
            );
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
                    $email = $row["email"];
                    $fname = $row["fname"];
                    $lname = $row["lname"];
                    $role = $row["role"];
                    $username = $row["username"];
                    $password_hashed = $row["password"];
                    $usr_id = $row["user_id"];
                    $fa = $row["2fa"];
                    $_SESSION['id'] = $usr_id;
                    // Check if the password matches:
                }
                $stmt->close();
            }
            $conn->close();
        }

        function add2fa()
        {
            global $errorMsg, $success, $secret;
            $config = parse_ini_file("../../private/db-config.ini");
            $conn = new mysqli(
                $config["servername"],
                $config["username"],
                $config["password"],
                $config["dbname"]
            );

            $secret = mysqli_real_escape_string($conn, $secret);
            $userid = mysqli_real_escape_string($conn, $_SESSION['id']);

            // Check connection     
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {

                // Prepare the statement:         
                $stmt = $conn->prepare("UPDATE users SET 2fa = ? WHERE user_id = ?;");
                //Bind & execute the query statement:         
                $stmt->bind_param("si", $secret, $userid);
                if (!$stmt->execute()) {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $stmt->close();
            }
            $conn->close();
        }

        function remove2fa()
        {
            global $errorMsg, $success, $secret;
            $config = parse_ini_file("../../private/db-config.ini");
            $conn = new mysqli(
                $config["servername"],
                $config["username"],
                $config["password"],
                $config["dbname"]
            );

            $secret = NULL;
            $userid = mysqli_real_escape_string($conn, $_SESSION['id']);

            // Check connection     
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {

                // Prepare the statement:         
                $stmt = $conn->prepare("UPDATE users SET 2fa = ? WHERE user_id = ?;");
                //Bind & execute the query statement:         
                $stmt->bind_param("si", $secret, $userid);
                if (!$stmt->execute()) {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $stmt->close();
            }
            $conn->close();
        }
        ?>
    </body>
</main>