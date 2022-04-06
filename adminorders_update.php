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

        require("conn.php");
        if (isset($_POST['uid'])) {
            $order_id = $_POST['order_id'];
            $pid = $_POST['pid'];
            $uid = $_POST['uid'];
            $sql = "SELECT * FROM `orders` WHERE `order_id`= ? AND pid = ? AND uid = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $order_id, $pid , $uid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $order_id = $row['order_id'];
                    $pid = $row['pid'];
                    $uid = $row['uid'];
                    $t_price = $row['total_price'];
                    $s_date = $row['shipment_date'];
                    $qty = $row['qty'];
                }
            } else {
                header('Location: adminorders.php');
            }
        }

        ?>

        <h1>Update Orders</h1>

        <form action="adminorders_update_p.php" method="post">
            <fieldset>
                <div class="form-group">
                    <label for="order_id">Order ID:</label>
                    <input class="form-control" type="number" id="order_id" name="order_id" value="<?php echo $order_id; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="pid">Product ID:</label>
                    <input class="form-control" type="number" id="pid" step=1 name="pid_" required maxlength="20" value="<?php echo $pid; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="uid">User ID:</label>
                    <input class="form-control" type="number" id="uid" step=1 name="uid_" required maxlength="20" value="<?php echo $uid; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="t_price">Total Price:</label>
                    <input class="form-control" type="number" id="t_price" step=0.01 name="t_price" required maxlength="20" value="<?php echo $t_price; ?>">
                </div>
                <div class="form-group">
                    <label for="s_date">Shipment Date:</label>
                    <input class="form-control" type="date" id="s_date" name="s_date" required value="<?php echo $s_date; ?>">
                </div>
                <div class="form-group">
                    <label for="s_date">Quantity:</label>
                    <input class="form-control" type="number" id="qty" name="qty" required value="<?php echo $qty; ?>">
                </div>
                <div class="form-group">
                    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                    <button class="btn btn-primary" type="submit" value="update" name="update">Submit</button>
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

                    <div>
                        <p id="errorMsg">
                        </p>
                    </div>
                </div>
            </fieldset>
        </form>
</body>



<script>
    var errorMsg = getCookie("errorMsg");
    if (errorMsg == null) {
        errorMsg = " ";
    }
    document.getElementById('errorMsg').innerHTML += errorMsg
</script>

</html>