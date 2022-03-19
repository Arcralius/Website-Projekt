<!DOCTYPE HTML>

<head>
    <title>Add Promotions</title>
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

		$prod_id = $discount = $errorMsg = "";
        $success = true;
        if (empty($_POST["prod_id"])) {
            $errorMsg .= "Product id is required.<br>";
            $success = false;
        } else {
            $prod_id = sanitize_input($_POST["prod_id"]);
        }

        if (empty($_POST["discount"])) {
            $errorMsg .= "Discount is required.<br>";
            $success = false;
        } else {
            $discount = sanitize_input($_POST["discount"]);
        }
        

        if ($success) {
            savePromotionToDB();
        }

        if ($success) {
            echo "<h3>Promotion entry added!</h3>";
            echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminpromotions.php'\">Back to promotion table</button>";
        } else {
            echo "<h3>Oops!</h3>";
            echo "<h4>The following errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo "<br><button class=\"btn btn-danger\" type=\"submit\" onclick=\"window.location.href='adminpromotions_add.php'\">Return to add</button>";
        }

//Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        function savePromotionToDB() {
            global $prod_id, $discount, $errorMsg, $success;
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
                $stmt = $conn->prepare("INSERT INTO promotions (prod_id, discount) VALUES (?, ?)");
                // Bind & execute the query statement:
                $stmt->bind_param("ii", $prod_id, $discount);
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