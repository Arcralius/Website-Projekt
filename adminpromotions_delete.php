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
            $pid = 0;
            $pid = mysqli_real_escape_string($conn,(int) sanitize_input($_GET['promotion_id']));
            $stmt = $conn->prepare("DELETE FROM `promotions` WHERE `promotion_id`=?");
            $stmt->bind_param("i", $pid);
            if ($stmt->execute()) {
                echo "<h3>Promotion deleted successfully!</h3>";
                echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminpromotions.php'\">Back to promotion table</button>";
            }
            else{
                echo "An Error has occured. Please contact a system administrator.";
            }
        }

        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?> 
</main>


</body>