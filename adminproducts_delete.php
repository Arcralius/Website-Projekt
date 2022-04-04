<!DOCTYPE HTML>
<html lang="en">
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
            if (isset($_POST['product_id'])) {
                $pid = mysqli_real_escape_string($conn, sanitize_input($_POST['product_id']));
                $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
                $stmt->bind_param("i", $pid);
                echo "<h1>".$pid."</h1>";
                if ($stmt->execute()) {
                    echo '<script>';
                    echo 'createCookie("succmessage", "Deletion success!", 1);';
                    echo 'window.location.href = "adminproducts.php";';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo 'createCookie("errorMsg", "An error occoured. Is product in promotion.", 1);';
                    echo 'window.location.href = "adminproducts.php";';
                    echo '</script>';
                }
            }

            function sanitize_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            ?>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>