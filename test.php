<?php
        if ($conn->connect_error) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        } else {
            global $errorMsg, $success;

            // Prepare the statement:         
            $stmt = $conn->prepare("SELECT * FROM `products` where product_category = (SELECT product_category from `products` where product_id = ?");
            // Bind & execute the query statement:         
            $stmt->bind_param("i", $productID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // output data of each row
                // while ($row = $result->fetch_assoc()) 
                $row = $result->fetch_assoc();
    
                $productImage = $row['product_image'];
                $productName = $row['product_name'];
                $productPrice = $row['product_price'];
    
                echo '<div class="col mb-5">';
                echo '<div class="card h-100">';
                echo '<img class="card-img-top" src="' . $productImage . '" alt="..." />';
                echo '<div class="card-body p-4">';
                echo '<div class="text-center">';
                echo '<h5 class="fw-bolder">' . $productName . '</h5>';
                echo '<span class="text-muted text-decoration-line-through">' . $productPrice . '</span>';
                echo '</div>';
                echo '</div>';
                echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                echo '<div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id=' . $row['product_id'] . '">View options</a></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
             else {
                $errorMsg = "Username not found or password doesn't match.<br>";
                $success = false;
            }
            $stmt->close();
        }
















        global $productName, $productPrice, $productImage, $quantity, $description, $productID;


        $stmt = $conn->prepare("SELECT * FROM `products` where product_id = ? ; ");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) 
            $row = $result->fetch_assoc();

            $productImage = $row['product_image'];
            $productName = $row['product_name'];
            $productPrice = $row['product_price'];
            $quantity = $row['product_quantity'];
            $description = $row['product_desc'];

            echo '<div class="col-md-6"><img class="card-img mb-5 mb-md-0" src="' . $productImage . '" alt="..." /></div>';
            echo '<div class="col-md-6">';
            echo '<h1 class="display-5 fw-bolder">' . $productName . '</h1>';
            echo '<div class="fs-5 mb-5">';
            echo '<span class="text-decoration-line-through">$' . $productPrice . '</span>';
            echo '<span>$' . $productPrice . '</span>';
            echo '</div>';
            echo '<p class="lead">' . $description . '</p>';
        } else {
            echo "0 results";
        }
        $conn->close();



        $stmt = $conn->prepare("UPDATE `orders` SET `pid`=?,`uid`=?,`shipment_date`=? WHERE `order_id`=?");
        // Bind & execute the query statement:
        $stmt->bind_param("iisi", $pid, $uid, $s_date, $order_id);
        if (!$stmt->execute()) {
            $errorMsg = "Error! Cannot find product id or user id.";
            $success = false;
        }
        if ($success) {
            echo '<script>';
            echo 'createCookie("succmessage", "Update success!", 1);';
            echo 'window.location.href = "adminorders.php";';
            echo '</script>';
        } else {
            echo '<script>';
            echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
            echo 'window.location.href = "adminorders.php";';
            echo '</script>';
        }
        $stmt->close();


        if (isset($_POST['order_id'])) {
            $order_id = $_POST['order_id'];
            $stmt = $conn->prepare("DELETE FROM `orders` WHERE `order_id`=?");
            $stmt->bind_param("i", $order_id);
            if (!$stmt->execute()) {
                $errorMsg = "Error! Cannot order.";
                $success = false;
            }
            if ($success) {
                echo '<script>';
                echo 'createCookie("succmessage", "Deletion success!", 1);';
                echo 'window.location.href = "adminorders.php";';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                echo 'window.location.href = "adminorders.php";';
                echo '</script>';
            }
        }