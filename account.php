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
            <!-- <a class="nav-link" href="https://www.bootdey.com/snippets/view/bs5-profile-billing-page" target="__blank">Billing</a>
            <a class="nav-link" href="https://www.bootdey.com/snippets/view/bs5-profile-security-page" target="__blank">Security</a> -->

        <hr class="mt-0 mb-4">
        <!-- Account details card-->
        <div class="card mb-4">
            <div class="card-header"><h1>Account Details</h1></div>
            <div class="card-body">
                <form action="updateaccountprocess.php" method="post" class="update-form">
                    <!-- Form Group (username)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="inputUsername">Change Username (how your name will appear to other users on the site)</label>
                        <?php
                        echo '<input class="form-control" id="inputUsername" type="text" requied name="username" placeholder="' . $username . '" value="' . $username . '"> ';
                        ?>
                    </div>
                    <div class="row gx-3 mb-3">
                        <!-- Form Group (first name)-->
                        <div class="col-md-6">
                            <label class="small mb-1" for="inputFirstName">Change First name</label>
                            <?php
                            echo '<input class="form-control" id="inputFirstName" type="text" name="fname" placeholder="' . $fname . '" value="' . $fname . '"> ';
                            ?>

                        </div>
                        <!-- Form Group (last name)-->
                        <div class="col-md-6">
                            <label class="small mb-1" for="inputLastName">Change Last name</label>
                            <?php
                            echo '<input class="form-control" id="inputLastName" type="text" requied name="lname" placeholder="' . $lname . '" value="' . $lname . '"> ';
                            ?>
                        </div>
                    </div>
                    <!-- Form Group (email address)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="inputEmailAddress">Change Email address</label>

                        <?php
                        echo '<input class="form-control" id="inputEmailAddress" type="email" requied name="email" placeholder="' . $email . '" value="' . $email . '"> ';
                        ?>
                    </div>
                    <!-- Save changes button-->
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

        <div class="mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changepw">
            Change Password
        </button>
        </div>

        <div class="mb-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#comfirm">
            Delete account
        </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="comfirm" title="delete" tabindex="-1" aria-labelledby="comfirm" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="delete">Are you sure?</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="deleteaccountprocess.php" method="post">
                            <p>Please enter your password to comfirm once more.</p>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                            <p id="errorsign">Once done cannot be undone!</p>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" title="changepw" id="changepw" tabindex="-1" aria-labelledby="changepw" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Change Password</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="changepasswordprocess.php" method="post">
                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                <input type="password" class="form-control" id="old_password" placeholder="Old Password" name="old_password">
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" placeholder="New Password" name="new_password">
                            </div>
                            <div class="form-group">
                                <label for="cfm_new_password">Comfirm New Password</label>
                                <input type="password" class="form-control" id="cfm_new_password" placeholder="Comfirm New Password" name="cfm_new_password">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Comfirm</button>
                            </div>
                        </form>
                    </div>
                </div>
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

        <?php function takeinfo()
        {
            global $errorMsg, $success, $fname, $lname, $password_hashed, $role, $username, $email;
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