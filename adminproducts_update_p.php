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
            $product_id = sanitize_input($_POST['product_id']);
            $p_name = sanitize_input($_POST['p_name']);
            $p_desc = sanitize_input($_POST['p_desc']);
            $p_category = sanitize_input($_POST['p_category']);
            $p_image = sanitize_input($_POST['p_image']);
            $p_thumbnail = sanitize_input($_POST['p_thumbnail']);
            $p_price = sanitize_input($_POST['p_price']);
            $p_quantity = sanitize_input((int)$_POST['p_quantity']);


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