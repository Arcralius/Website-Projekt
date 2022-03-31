<!DOCTYPE HTML>

<head>
    <title>Update Promotion</title>
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
        
        if (isset($_POST['update'])) {
            $pid = $prod_id = $discount = 0;
            $sdate = $edate = "";
            $pid = sanitize_input((int)$_POST['promotion_id']);
            $prod_id = sanitize_input((int)$_POST['prod_id']);
            
            $discount = sanitize_input((int)$_POST['discount']);
            $sdate = sanitize_input((string)$_POST['sdate']);
            $edate = sanitize_input((string)$_POST['edate']);
            $stmt = $conn->prepare("UPDATE `promotions` SET `prod_id`=?,`discount`=?, `start_date`=?, `end_date`=? WHERE `promotion_id`=?");
            $pid = mysqli_real_escape_string($conn, $pid);
            $prod_id = mysqli_real_escape_string($conn, $prod_id);
            $discount = mysqli_real_escape_string($conn, $discount);
            $sdate = mysqli_real_escape_string($conn, $sdate);
            $edate = mysqli_real_escape_string($conn, $edate);
            // Bind & execute the query statement:
            $stmt->bind_param("iissi", $prod_id, $discount, $sdate, $edate, $pid);
            if (!$stmt->execute()) {
                echo '<script>';
                echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                echo 'window.location.href = "adminpromotions_update.php";';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'createCookie("succmessage", "Update success!", 1);';
                echo 'window.location.href = "adminpromotions.php";';
                echo '</script>';
            }
            $stmt->close();
        }
        ?>

</body>

</html>
</main>
<?php include 'footer.php';?>


</body>