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
    
    require("conn.php");
    function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        if (isset($_POST['update'])) {
            $order_id = sanitize_input((int)$_GET['order_id']);
            $pid = sanitize_input((int)$_POST['pid']);
            $uid = sanitize_input((int)$_POST['uid']);
            $s_date = sanitize_input($_POST['s_date']);


            $stmt = $conn->prepare("UPDATE `orders` SET `pid`=?,`uid`=?,`shipment_date`=? WHERE `order_id`=?");
            // Bind & execute the query statement:
            $stmt->bind_param("iisi", $pid, $uid, $s_date, $order_id);
            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }
            else{
                echo "<h3>Order entry updated!</h3>";
                echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminorders.php'\">Back to order table</button>";
            }
            $stmt->close();
        } 

    if (isset($_GET['order_id'])) {
        $order_id = $_GET['order_id']; 
        $sql = "SELECT * FROM `orders` WHERE `order_id`='$order_id'";
        $result = $conn->query($sql); 
        if ($result->num_rows > 0) {        
            while ($row = $result->fetch_assoc()) {
                $order_id = $row['order_id'];
                $pid = $row['pid'];
                $uid = $row['uid'];
                $s_date = $row['shipment_date'];
            } 
            
        ?>
        
            <h1>Update Orders</h1>

            <form action="" method="post">
              <fieldset>
                <div class="form-group">
                <label for="order_id">Order ID:</label>
                <input class="form-control" type="number" name="order_id" value="<?php echo $order_id; ?>" disabled>
                </div>
                <div class="form-group">
                <label for="pid">Product ID:</label>
                <input class="form-control" type="number" step=1 name="pid" required maxlength="20" value="<?php echo $pid; ?>">
                </div>
                <div class="form-group">
                <label for="uid">User ID:</label>
                <input class="form-control" type="number" step=1 name="uid" required maxlength="20" value="<?php echo $uid; ?>">
                </div>
                <div class="form-group">
                <label for="s_date">Shipment Date:</label>
                <input class="form-control" type="date" name="s_date" required value="<?php echo $s_date; ?>">
                </div>
                <div class="form-group">
                <button class="btn btn-primary" type="submit" value="update" name="update">Submit</button>
                </div>
              </fieldset>
            </form> 
            </body>
            </html>
            
        <?php
        } else{ 
            header('Location: adminorders.php');
        } 
    }

?> 
</main>


</body>