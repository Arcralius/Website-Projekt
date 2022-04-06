<!DOCTYPE HTML>

<head>
    <title>Add Orders</title>
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
		$oid = $qty = $pid = $uid = $t_price = $s_date = $errorMsg = "";
        
        if (empty($_POST["oid"])) {
            $errorMsg .= "Order id is required.<br>";
            $success = false;
        } else {
            $oid = sanitize_input($_POST["oid"]);
        }
        if (empty($_POST["pid"])) {
            $errorMsg .= "Product id is required.<br>";
            $success = false;
        } else {
            $pid = sanitize_input($_POST["pid"]);
        }

        if (empty($_POST["uid"])) {
            $errorMsg .= "User id is required.<br>";
            $success = false;
        } else {
            $uid = sanitize_input($_POST["uid"]);
        }

        if (empty($_POST["t_price"])) {
            $errorMsg .= "Total price is required.<br>";
            $success = false;
        } else {
            $t_price = sanitize_input($_POST["t_price"]);
        }

        if (empty($_POST["s_date"])) {
            $errorMsg .= "Shipment date is required.<br>";
            $success = false;
        } else {
            $s_date = sanitize_input($_POST["s_date"]);
        }

        if (empty($_POST["qty"])) {
            $errorMsg .= "Quantity is required.<br>";
            $success = false;
        } else if (!preg_match("/^[1-9]+$/", $_POST["qty"])) {
            $errorMsg .= "Invalid quantity.<br>";
            $success = false;
        } else {
            $qty = sanitize_input($_POST["qty"]);
        }
        

        if ($success) {
            savePromotionToDB();
            if ($success) {
                echo '<script>';
                echo 'createCookie("succmessage", "Order add success!", 1);';
                echo 'window.location.href = "adminorders.php";';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'createCookie("errorMsg", "'.$errorMsg.'", 1);';
                echo 'window.location.href = "adminorders_add.php";';
                echo '</script>';
            }
        }
        else {
            echo '<script>';
            echo 'createCookie("errorMsg", "'.$errorMsg.'", 1);';
            echo 'window.location.href = "adminorders_add.php";';
            echo '</script>';
        }



//Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function savePromotionToDB() {
            global $oid, $pid, $uid, $t_price, $s_date, $errorMsg, $success, $qty;
            // Create database connection.
            require("conn.php");
            // Check connection
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {
                // Prepare the statement:
                $stmt = $conn->prepare("INSERT INTO orders (order_id, pid, uid, total_price, shipment_date, qty) VALUES (?, ?, ?, ?, ?, ?)");
                // Bind & execute the query statement:
                $stmt->bind_param("iiidsi", $oid, $pid, $uid, $t_price, $s_date, $qty);
                if (!$stmt->execute()) {
                    $errorMsg = "User/Product ID not found";
                    $success = false;
                }
                $stmt->close();
            }
            $conn->close();
        }
		
	?>
    </main>

</body>