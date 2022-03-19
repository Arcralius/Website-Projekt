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

		$pid = $uid = $s_date = $errorMsg = "";
        $success = true;
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

        if (empty($_POST["s_date"])) {
            $errorMsg .= "Shipment date is required.<br>";
            $success = false;
        } else {
            $s_date = sanitize_input($_POST["s_date"]);
        }
        

        if ($success) {
            savePromotionToDB();
        }

        if ($success) {
            echo "<h3>Order entry added!</h3>";
            echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminorders.php'\">Back to order table</button>";
        } else {
            echo "<h3>Oops!</h3>";
            echo "<h4>The following errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo "<br><button class=\"btn btn-danger\" type=\"submit\" onclick=\"window.location.href='adminorders_add.php'\">Return to add</button>";
        }

//Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        function savePromotionToDB() {
            global $pid, $uid, $s_date, $errorMsg, $success;
            // Create database connection.
            /**$config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'],
                    $config['password'], $config['dbname']);**/
            require("conn.php");
            // Check connection
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {
                // Prepare the statement:
                $stmt = $conn->prepare("INSERT INTO orders (pid, uid, shipment_date) VALUES (?, ?, ?)");
                // Bind & execute the query statement:
                $stmt->bind_param("iis", $pid, $uid, $s_date);
                if (!$stmt->execute()) {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $stmt->close();
            }
            $conn->close();
        }
		
	?>
    </main>

</body>