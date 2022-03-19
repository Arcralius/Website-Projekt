<!DOCTYPE HTML>

<head>
    <title>Delete Promotions</title>
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
        if (isset($_GET['promotion_id'])) {
            $promotion_id = $_GET['promotion_id'];
            $sql = "DELETE FROM `promotions` WHERE `promotion_id`='$promotion_id'";
            $result = $conn->query($sql);
            if ($result == TRUE) {
                echo "<h3>Promotion deleted successfully!</h3>";
                echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminpromotions.php'\">Back to promotion table</button>";
            }
            else{
                echo "Error:" . $sql . "<br>" . $conn->error;
            }
        }

    ?> 
</main>


</body>