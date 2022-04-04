<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Delete Orders</title>
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
            if (isset($_POST['order_id'])) {
                $order_id = $_POST['order_id'];
                $stmt = $conn->prepare("DELETE FROM `orders` WHERE `order_id`=?");
                $stmt->bind_param("i", $order_id);
                if (!$stmt->execute()) {
                    $errorMsg = "Error! Cannot find order.";
                    $success = false;
                }
                if ($success) {
                    echo '<script>';
                    echo 'createCookie("succmessage", "Deletion success!", 1);';
                    echo 'window.location.href = "adminorders.php";';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                    echo 'window.location.href = "adminorders.php";';
                    echo '</script>';
                }
            }

            ?>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>