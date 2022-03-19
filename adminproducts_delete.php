<!DOCTYPE HTML>

<head>
    <title>test</title>
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
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            $sql = "DELETE FROM `products` WHERE `product_id`='$product_id'";
            $result = $conn->query($sql);
            if ($result == TRUE) {
                echo "<h3>Product deleted successfully!</h3>";
                echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminproducts.php'\">Back to product table</button>";
            }
            else{
                echo "Error:" . $sql . "<br>" . $conn->error;
            }
        }

    ?> 
</main>


</body>