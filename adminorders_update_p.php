<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Update Order</title>
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
                $order_id = sanitize_input((int)$_POST['order_id']);
                $pid = sanitize_input((int)$_POST['pid']);
                $uid = sanitize_input((int)$_POST['uid']);
                $s_date = sanitize_input($_POST['s_date']);


                $stmt = $conn->prepare("UPDATE `orders` SET `pid`=?,`uid`=?,`shipment_date`=? WHERE `order_id`=?");
                // Bind & execute the query statement:
                $stmt->bind_param("iisi", $pid, $uid, $s_date, $order_id);
                if (!$stmt->execute()) {
                    $errorMsg = "Error! Cannot find product id or user id.";
                    $success = false;
                }
                if ($success) {
                    echo '<script>';
                    echo 'createCookie("succmessage", "Update success!", 1);';
                    echo 'window.location.href = "adminorders.php";';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                    echo 'window.location.href = "adminorders.php";';
                    echo '</script>';
                }
                $stmt->close();
            }
            ?>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>