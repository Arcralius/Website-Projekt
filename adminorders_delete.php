<!DOCTYPE HTML>

<head>
    <title>Delete Orders</title>
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
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
            $sql = "DELETE FROM `orders` WHERE `order_id`='$order_id'";
            $result = $conn->query($sql);
            if ($result == TRUE) {
                echo "<h3>Order deleted successfully!</h3>";
                echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminorders.php'\">Back to order table</button>";
            }
            else{
                echo "Error:" . $sql . "<br>" . $conn->error;
            }
        }

    ?> 
</main>


</body>