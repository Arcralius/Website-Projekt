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
        $success = true;

        require("conn.php");
        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        if (isset($_POST['update'])) {
            $user_id = sanitize_input($_POST['user_id']);
            $role = sanitize_input($_POST['role']);


            $stmt = $conn->prepare("UPDATE `users` SET `role`=? WHERE `user_id`=?");
            // Bind & execute the query statement:
            $stmt->bind_param("si", $role, $user_id);
            if (!$stmt->execute()) {
                $errorMsg = "An error has occoured";
                $success = false;
            } 
            if ($success) {
                echo '<script>';
                echo 'createCookie("succmessage", "Update success!", 1);';
                echo 'window.location.href = "adminusers.php";';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                echo 'window.location.href = "adminusers.php";';
                echo '</script>';
            }
            $stmt->close();
        }
?>
</body>

</html>

</main>


</body>