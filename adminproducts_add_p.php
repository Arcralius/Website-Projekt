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

        

        /* Get the name of the file uploaded to Apache */
        $filename = $_FILES['file']['name'];

        if (($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/png")){
            /* Prepare to save the file upload to the upload folder */
            $location = "img/".$filename;
            /* Permanently save the file upload to the upload folder */
            if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) { 
              echo '<p>File upload was a success!</p>'; 
            } else { 
              echo '<p>File upload failed.</p>'; 
            }
        }
        else {
        //error
        $errorMsg .= "Wrong Image.<br>";
        $success = false;
        }

        if (($_FILES["file2"]["type"] == "image/gif") || ($_FILES["file2"]["type"] == "image/jpeg") || ($_FILES["file2"]["type"] == "image/jpg") || ($_FILES["file2"]["type"] == "image/png")){
            /* Get the name of the file uploaded to Apache */
            $filename2 = $_FILES['file2']['name'];
            /* Prepare to save the file upload to the upload folder */
            $location2 = "img/".$filename2;
            /* Permanently save the file upload to the upload folder */
            if ( move_uploaded_file($_FILES['file2']['tmp_name'], $location2) ) { 
              echo '<p>File upload was a success!</p>';
            } else { 
              echo '<p>File upload failed.</p>'; 
            }
        } 
        else {
            //error
            $errorMsg .= "Wrong Image.<br>";
            $success = false;
        }

        

        if ($success) {
            saveProductToDB();
        }

        if ($success) {
            echo '<script>';
            echo 'createCookie("succmessage", "Add success!", 1);';
            echo 'window.location.href = "adminproducts.php";';
            echo '</script>';
        } else {
            echo '<script>';
            echo 'createCookie("errorMsg", "'.$errorMsg.'", 1);';
            echo 'window.location.href = "adminproducts_add.php";';
            echo '</script>';
        }

//Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        function saveProductToDB() {
            global $p_name, $p_desc, $p_category, $p_image, $p_thumbnail, $p_price, $p_quantity, $location, $location2, $errorMsg, $success;
            // Create database connection.
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
                $stmt->bind_param("sssssdi", $p_name, $p_desc, $p_category, $location, $location2, $p_price, $p_quantity);
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