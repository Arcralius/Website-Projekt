<!DOCTYPE HTML>
<html lang="en">
<main>

    <head>

        <?php
        include 'header.php';
        ?>
    </head>

    <body>

        <?php
        include 'navbar.php';

        if (!isset($_SESSION['username'])) {
            header("Location: /Website-Projekt/signin.php");
        } else {
            $username = $_SESSION['username'];
        }
        takeinfo();
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
                    <h1>Enable 2 Factor Authentication?</h1>
                </div>
                <div class="card-body">
                    <form action="2faprocess.php" method="post" class="update-form">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="2fa">Change Username (how your name will appear to other users on the site)</label>
                            <br>
                            <select name="fa" id="fa" value="<?php echo $role; ?>">
                            <?php
                            if ($fa == NULL) {
                                echo '<option value="No">No</option>';
                                echo '<option value="Yes">Yes</option>';
                            } else {
                                echo '<option value="Yes">Yes</option>';
                                echo '<option value="No">No</option>';
                            }
                            ?>
                            </select>
                        </div>
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Save Changes</button>
                    </form>
                </div>
            </div>
            <div>
                <p id="succmessage">
                </p>
                <p id="errormsg">
                </p>
            </div>
        </div>


        <script>
            var succmessage = getCookie("succmessage");
            if (succmessage == null) {
                succmessage = " ";
            }
            document.getElementById('succmessage').innerHTML += succmessage;

            var errormsg = getCookie("errorMsg");
            if (errormsg == null) {
                errormsg = " ";
            }
            document.getElementById('errormsg').innerHTML += errormsg;
        </script>

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
        ?>
    </body>
</main>