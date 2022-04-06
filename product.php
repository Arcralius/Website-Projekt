<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <?php
    include 'header.php';
    ?>
</head>

<body>
    <main>
        <?php
        include 'navbar.php';
        if (!isset($_POST["productID"])) {
            echo '<script>';
            echo 'window.location.href = "products.php";';
            echo '</script>';
        }
        $productID = htmlspecialchars($_POST["productID"]);
        ?>
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <?php
                    getproducts();
                    checkStocks();
                    ?>
                </div>
            </div>
        </section>
        <!-- Related items section-->
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    getRelatedProducts()
                    ?>
                </div>
            </div>
        </section>




        <?php
        include 'footer.php';
        function getproducts()
        {
            require("conn.php");
            global $productName, $productPrice, $productImage, $quantity, $description, $productID;
            $stmt = $conn->prepare("SELECT * FROM `products` where product_id = ? ;");
            $stmt->bind_param("i", $productID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // output data of each row
                // while ($row = $result->fetch_assoc()) 
                $row = $result->fetch_assoc();
                $discount = checkPromo($productID);
                $productImage = $row['product_image'];
                $productName = $row['product_name'];
                $productPrice = $row['product_price'];
                $quantity = $row['product_quantity'];
                $description = $row['product_desc'];

                echo '<div class="col-md-6"><img class="card-img mb-5 mb-md-0" src="' . $productImage . '" alt="..." /></div>';
                echo '<div class="col-md-6">';
                echo '<h1 class="display-5 fw-bolder">' . $productName . '</h1>';
                echo '<div class="fs-5 mb-5">';
                $discount = checkPromo($productID);
                if ($discount != NULL) {
                    echo '<span class="text-muted text-decoration-line-through">$' . $productPrice . '</span>';
                    echo '<span class="text"> $' . number_format($productPrice * $discount, 2) . '</span>';
                } else {
                    echo '<span class="text">$' . $productPrice . '</span>';
                }
                echo '</div>';
                echo '<p class="lead">' . $description . '</p>';
            } else {
                echo "0 results";
            }
            $conn->close();
        }
        function getRelatedProducts()
        {
            require("conn.php");
            $productID = htmlspecialchars($_POST["productID"]);

            $stmt = $conn->prepare("SELECT * FROM `products` where product_category = (SELECT product_category from `products` where product_id = ? ) && product_id != ? ; ");
            $stmt->bind_param("ii", $productID, $productID);
            $stmt->execute();
            $result = $stmt->get_result();

            // $sql = "SELECT * FROM `products` where product_category = (SELECT product_category from `products` where product_id = $productID ) && product_id != $productID ; ";
            // $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                // while ($row = $result->fetch_assoc()) 
                $row = $result->fetch_assoc();

                $productImage = $row['product_image'];
                $productName = $row['product_name'];
                $productPrice = $row['product_price'];
                $productID = $row['product_id'];
                echo '<div class="col mb-5">';
                echo '<div class="card h-100">';
                echo '<img class="card-img-top" src="' . $productImage . '" alt="..." />';
                echo '<div class="card-body p-4">';
                echo '<div class="text-center">';
                echo '<p class="fw-bolder">' . $productName . '</p>';
                $discount2 = checkPromo($productID);
                if ($discount2 == NULL) {
                    echo '<span class="text">$' . $productPrice . '</span>';
                } else {
                    echo '<span class="text-muted text-decoration-line-through">$' . $productPrice . '</span>';
                    echo '<span class="text"> $' . number_format($productPrice * $discount2, 2) . '</span>';
                }

                echo '</div>';
                echo '</div>';
                echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                echo '<form action="product.php" method="post">';
                echo '<input type="hidden" name="productID" value="' . $productID . '">';
                //echo '<div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id=' . $row['product_id'] . '">View options</a></div>';
                echo '<button type="submit" class="form-control btn btn-outline-dark rounded submit px-3">View Details</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            $stmt->close();
            $conn->close();
        }
        function checkStocks()
        {

            require("conn.php");
            $productID = htmlspecialchars($_POST["productID"]);

            $stmt = $conn->prepare("SELECT product_quantity FROM `products` where product_id = ? ;");
            $stmt->bind_param("i", $productID);
            $stmt->execute();
            $result = $stmt->get_result();

            // $sql = "SELECT product_quantity FROM `products` where product_id = $productID ; ";
            // $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                // while ($row = $result->fetch_assoc()) 
                $row = $result->fetch_assoc();

                $productQty = $row['product_quantity'];

                if (isset($_SESSION['username'])) {
                    if ($productQty == 0) {
                        echo '<h3>Out of Stock!</h3>';
                    } else {
                        echo '<p>In stock: ' . $productQty . '</p>';
                        echo '<div class="d-flex">';
                        echo '<button name="addtocart" value="' . $productID . '"class="btn btn-outline-dark flex-shrink-0">Add to Cart</button>';
                    }
                } else {
                    echo '<p>You must be signed in to add to cart</p>';
                }
            } else {
                echo "0 results";
            }
            $stmt->close();
            $conn->close();
        }
        function checkPromo($id)
        {
            require("conn.php");

            $stmt = $conn->prepare("SELECT discount FROM `promotions` where prod_id = ?;");

            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $discount2 = $row['discount'];
                $discount2 = (100 - $discount2) / 100;
            } else {
                $discount2 = NULL;
            }



            $stmt->close();
            $conn->close();

            return $discount2;
        }
        ?>
</main>
</body>


</html>