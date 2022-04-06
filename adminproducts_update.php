<!DOCTYPE HTML>

<html lang="en">

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

        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            $sql = "SELECT * FROM `products` WHERE `product_id`=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $p_name = $row['product_name'];
                    $p_desc = $row['product_desc'];
                    $p_category = $row['product_category'];
                    $p_image  = $row['product_image'];
                    $p_thumbnail = $row['product_thumbnail'];
                    $p_price = $row['product_price'];
                    $p_quantity = $row['product_quantity'];
                }
        ?>

                <h1>Update Products</h1>

                <form action="adminproducts_update_p.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="p_id">Product ID:</label>
                            <input class="form-control" type="text" id="p_id" name="product_id" value="<?php echo $product_id; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="p_name">Product Name:</label>
                            <input class="form-control" type="text" id="p_name" name="p_name" required maxlength="45" value="<?php echo $p_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="p_desc">Description:</label>
                            <input class="form-control" type="text" id="p_desc" name="p_desc" required maxlength="255" value="<?php echo $p_desc; ?>">
                        </div>
                        <div class="form-group">
                            <label for="p_category">Category:</label>
                            <input class="form-control" type="text" id="p_category" name="p_category" required maxlength="45" value="<?php echo $p_category; ?>">
                        </div>
                        <div class="form-group">
                            <label for="p_image">Image:</label>
                            <input class="form-control" type="text" id="p_image" disabled maxlength="45" value="<?php echo $p_image; ?>">
                            <input class="form-control" type="hidden" name="p_image" value="<?php echo $p_image; ?>">
                            <!-- HTML5 Input Form  -->
                            <input id="p_image_img" type="file" name="file" aria-label="Update Image" />
                        </div>
                        <div class="form-group">
                            <label for="p_thumbnail">Image thumbnail:</label>
                            <input class="form-control" type="text" id="p_thumbnail" disabled maxlength="45" value="<?php echo $p_thumbnail; ?>">
                            <input class="form-control" type="hidden" name="p_thumbnail" value="<?php echo $p_thumbnail; ?>">
                            <!-- HTML5 Input Form  -->
                            <input id="p_thumbnail_img" type="file" name="file2" aria-label="Update Thumbnail" />
                        </div>
                        <div class="form-group">
                            <label for="p_price">Price:</label>
                            <input class="form-control" type="number" step=0.01 id="p_price" name="p_price" required maxlength="11" value="<?php echo $p_price; ?>">
                        </div>
                        <div class="form-group">
                            <label for="p_quantity">Quantity:</label>
                            <input class="form-control" type="number" step=1 id="p_quantity" name="p_quantity" required maxlength="11" value="<?php echo $p_quantity; ?>">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" value="update" name="update">Submit</button>
                        </div>
                        <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>">
                    </fieldset>
                </form>
</body>

</html>

<?php
            } else {
                header('Location: adminproduct.php');
            }
        }

?>
</main>


</body>