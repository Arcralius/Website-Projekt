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
    
    require("conn.php");
    function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        if (isset($_POST['update'])) {
            $product_id = sanitize_input($_GET['product_id']);
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
            else{
                echo "<h3>Product entry updated!</h3>";
                echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminproducts.php'\">Back to product table</button>";
            }
            $stmt->close();
        } 

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id']; 
        $sql = "SELECT * FROM `products` WHERE `product_id`='$product_id'";
        $result = $conn->query($sql); 
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

            <form action="" method="post">
              <fieldset>
                <div class="form-group">
                <label for="p_name">Product ID:</label>
                <input class="form-control" type="text" name="product_id" value="<?php echo $product_id; ?>" disabled>
                </div>
                <div class="form-group">
                <label for="p_name">Product Name:</label>
                <input class="form-control" type="text" name="p_name" required maxlength="45" value="<?php echo $p_name; ?>">
                </div>
                <div class="form-group">
                <label for="p_desc">Description:</label>
                <input class="form-control" type="text" name="p_desc" required maxlength="255" value="<?php echo $p_desc; ?>">
                </div>
                <div class="form-group">
                <label for="p_category">Category:</label>
                <input class="form-control" type="text" name="p_category" required maxlength="45" value="<?php echo $p_category; ?>">
                </div>
                <div class="form-group">
                <label for="p_image">Image:</label>
                <input class="form-control" type="text" name="p_image" required maxlength="45" value="<?php echo $p_image; ?>">
                </div>
                <div class="form-group">
                <label for="p_thumbnail">Image thumbnail:</label>
                <input class="form-control" type="text" name="p_thumbnail" required maxlength="45" value="<?php echo $p_thumbnail; ?>">
                </div>
                <div class="form-group">
                <label for="p_price">Price:</label>
                <input class="form-control" type="number" step=0.01 name="p_price" required maxlength="11" value="<?php echo $p_price; ?>">
                </div>
                <div class="form-group">
                <label for="p_quantity">Quantity:</label>
                <input class="form-control" type="number" step=1 name="p_quantity" required maxlength="11" value="<?php echo $p_quantity; ?>">
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
            header('Location: adminproduct.php');
        } 
    }

?> 
</main>


</body>