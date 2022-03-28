<!DOCTYPE HTML>

<head>
    <title>Update Users</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
    <?php
    include 'navbar.php';
    include 'adminsession.php';
    ?>

    <main class="container">
        <?php

        require("conn.php");
        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $sql = "SELECT * FROM `users` WHERE `user_id`='$user_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $username = $row['username'];
                    $email  = $row['email'];
                    $role = $row['role'];
                }

        ?>

                <h1>Update Users</h1>

                <form action="adminusers_update_p.php" method="post">
                    <fieldset>
                        <div class="form-group">
                            <label for="user_id">User ID:</label>
                            <input class="form-control" type="text" name="user_id" value="<?php echo $user_id; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="fname">First Name:</label>
                            <input class="form-control" type="text" name="fname" value="<?php echo $fname; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name:</label>
                            <input class="form-control" type="text" name="lname" value="<?php echo $lname; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="role" id="role" value="<?php echo $role; ?>">
                                <?php if ($role == "U") {
                                    echo '<option value="U">U</option>';
                                    echo '<option value="A">A</option>';
                                } else {
                                    echo '<option value="A">A</option>';
                                    echo '<option value="U">U</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id ?>">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" value="update" name="update">Submit</button>
                        </div>
                    </fieldset>
                    
                            
                </form>
</body>

</html>

<?php
            } else {
                header('Location: adminusers.php');
            }
        }

?>
</main>


</body>