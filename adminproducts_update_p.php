<!DOCTYPE HTML>

<head>
    <title>Update Products</title>
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
            global $product_id, $p_name, $p_desc, $p_category, $p_image, $p_thumbnail, $p_price, $p_quantity, $errorMsg;
            $product_id = sanitize_input($_POST['product_id']);
            $p_name = sanitize_input($_POST['p_name']);
            $p_desc = sanitize_input($_POST['p_desc']);
            $p_category = sanitize_input($_POST['p_category']);
            $p_price = sanitize_input($_POST['p_price']);
            $p_quantity = sanitize_input((int)$_POST['p_quantity']);

            
            //check if file upload was filled
            if (isset($_FILES['file']['name']))
            {
                if (($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/png")){
                    /* Get the name of the file uploaded to Apache */
                    $filename = $_FILES['file']['name'];
                    /* Prepare to save the file upload to the upload folder */
                    $location = "img/".$filename;
                    $p_image = $location;
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
            }
            else
            {
                $p_image = $_POST['p_image'];
            }
           
           
            //check if file upload was filled
            if (isset($_FILES['file2']['name']))
            {
                if (($_FILES["file2"]["type"] == "image/gif") || ($_FILES["file2"]["type"] == "image/jpeg") || ($_FILES["file2"]["type"] == "image/jpg") || ($_FILES["file2"]["type"] == "image/png")){
                    /* Get the name of the file uploaded to Apache */
                    $filename2 = $_FILES['file2']['name'];
                    /* Prepare to save the file upload to the upload folder */
                    $location2 = "img/".$filename2;
                    $p_thumbnail = $location2;
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
            }
            else
            {
                $p_thumbnail = $_POST['p_thumbnail'];
            }


            $stmt = $conn->prepare("UPDATE `products` SET `product_name`=?,`product_desc`=?,`product_category`=?,
`product_image`=?,`product_thumbnail`=?,`product_price`=?,`product_quantity`=? WHERE `product_id`=?");
            // Bind & execute the query statement:
            $stmt->bind_param("sssssdii", $p_name, $p_desc, $p_category, $p_image, $p_thumbnail, $p_price, $p_quantity, $product_id);
            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }   
            if ($success) {
                echo '<script>';
                echo 'createCookie("succmessage", "Update success!", 1);';
                echo 'window.location.href = "adminproducts.php";';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                echo 'window.location.href = "adminproducts.php";';
                echo '</script>';
            }
            $stmt->close();
        }
        ?>
</body>

</html>

</main>

</body>