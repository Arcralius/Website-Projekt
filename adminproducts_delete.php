<!DOCTYPE HTML>

<head>
    <title>Delete Products</title>
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
                echo '<script>';
                echo 'createCookie("succmessage", "Deletion success!", 1);';
                echo 'window.location.href = "adminproducts.php";';
                echo '</script>';
            }
            else{
                echo '<script>';
                echo 'createCookie("errorMsg", "'.$errorMsg.'", 1);';
                echo 'window.location.href = "adminproducts.php";';
                echo '</script>';
            }
        }

    ?> 
</main>


</body>