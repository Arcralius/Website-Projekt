<!DOCTYPE HTML>

<head>
    <title>Add Products</title>
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

		$p_name = $p_desc = $p_category = $p_image = $p_thumbnail = $p_price = $p_quantity = $errorMsg = "";
        $success = true;
        if (empty($_POST["p_name"])) {
            $errorMsg .= "Name is required.<br>";
            $success = false;
        } else {
            $p_name = sanitize_input($_POST["p_name"]);
        }

        if (empty($_POST["p_desc"])) {
            $errorMsg .= "Description is required.<br>";
            $success = false;
        } else {
            $p_desc = sanitize_input($_POST["p_desc"]);
        }

        if (empty($_POST["p_category"])) {
            $errorMsg .= "Category is required.<br>";
            $success = false;
        } else {
            $p_category = sanitize_input($_POST["p_category"]);
        }

        if (empty($_POST["p_image"])) {
            $errorMsg .= "Image link is required.<br>";
            $success = false;
        } else {
            $p_image = sanitize_input($_POST["p_image"]);
        }

        if (empty($_POST["p_thumbnail"])) {
            $errorMsg .= "Image thumbnail link is required.<br>";
            $success = false;
        } else {
            $p_thumbnail = sanitize_input($_POST["p_thumbnail"]);
        }
        if (empty($_POST["p_price"])) {
            $errorMsg .= "Price is required.<br>";
            $success = false;
        } else {
            $p_price = sanitize_input($_POST["p_price"]);
        }
        if (empty($_POST["p_quantity"])) {
            $errorMsg .= "Quantity is required.<br>";
            $success = false;
        } else {
            $p_quantity = sanitize_input((int)$_POST["p_quantity"]);
        }

        if ($success) {
            saveProductToDB();
        }

        if ($success) {
            echo "<h3>Product entry added!</h3>";
            echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminproducts.php'\">Back to product table</button>";
        } else {
            echo "<h3>Oops!</h3>";
            echo "<h4>The following errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo "<br><button class=\"btn btn-danger\" type=\"submit\" onclick=\"window.location.href='adminproducts_add.php'\">Return to add</button>";
        }

//Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        function saveProductToDB() {
            global $p_name, $p_desc, $p_category, $p_image, $p_thumbnail, $p_price, $p_quantity, $errorMsg, $success;
            // Create database connection.
            /**$config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'],
                    $config['password'], $config['dbname']);
            $conn->set_charset("utf8");**/
            require("conn.php");
            // Check connection
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {
                // Prepare the statement:
                $stmt = $conn->prepare("INSERT INTO products (product_name, product_desc, product_category, product_image, product_thumbnail,
 product_price, product_quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
                // Bind & execute the query statement:
                $stmt->bind_param("sssssdi", $p_name, $p_desc, $p_category, $p_image, $p_thumbnail, $p_price, $p_quantity);
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