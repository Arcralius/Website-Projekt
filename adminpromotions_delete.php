<!DOCTYPE HTML>

<head>
    <title>Delete Promotions</title>
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
        if (isset($_POST['promotion_id'])) {
            $pid = 0;
            $pid = mysqli_real_escape_string($conn, (int) sanitize_input($_POST['promotion_id']));
            $stmt = $conn->prepare("DELETE FROM `promotions` WHERE `promotion_id`=?");
            $stmt->bind_param("i", $pid);
            if ($stmt->execute()) {
                echo '<script>';
                echo 'createCookie("succmessage", "Deletion success!", 1);';
                echo 'window.location.href = "adminpromotions.php";';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'createCookie("errorMsg", "An Error has occured. Please contact a system administrator.", 1);';
                echo 'window.location.href = "adminpromotions.php";';
                echo '</script>';
            }
        }

        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>
    </main>
    <?php include 'footer.php';?>


</body>