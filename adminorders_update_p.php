<!DOCTYPE HTML>

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

        if (empty($_POST["qty"])) {
            $errorMsg .= "Quantity is required.<br>";
            $success = false;
        } else if (!preg_match("/^[0-9 ]*$/", $_POST["qty"])) {
            $errorMsg .= "Invalid quantity.<br>";
            $success = false;
        } else {
            $qty = sanitize_input($_POST["qty"]);
        }


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
            $t_price = sanitize_input($_POST['t_price']);
            $s_date = sanitize_input($_POST['s_date']);
            $qty = sanitize_input((int)$_POST['qty']);


            $stmt = $conn->prepare("UPDATE `orders` SET `total_price`=?, `shipment_date`=?, `qty`=? WHERE `order_id`=? AND `pid`=? AND `uid`=?");
            // Bind & execute the query statement:
            $stmt->bind_param("dsiiii", $t_price, $s_date, $qty, $order_id, $pid, $uid);

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


</body>