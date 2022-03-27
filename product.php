<!DOCTYPE HTML>

<head>
    <title>test</title>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Item - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
</head>
    <body>
        <?php
        include 'navbar.php';
        ?>
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <?php
                    getproducts()
                    ?>       
                    <?php
                    checkStocks()
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
                    
  
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        
        <?php
         function getproducts()
    {
        require("conn.php");
        
        $productID = htmlspecialchars($_GET["id"]);
        global $productName, $productPrice, $productImage, $quantity, $description;
        

        $sql = "SELECT * FROM `products` where product_id = $productID ; ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) 
            $row = $result->fetch_assoc();

            $productImage = $row['product_image'];
            $productName = $row['product_name'];
            $productPrice = $row['product_price'];
            $quantity = $row['product_quantity'];
            $description = $row['product_desc'];

            echo '<div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="'.$productImage.'" alt="..." /></div>';
            echo '<div class="col-md-6">';
            echo '<div class="small mb-1">SKU: BST-498</div>';
            echo '<h1 class="display-5 fw-bolder">'.$productName.'</h1>';
            echo '<div class="fs-5 mb-5">';
            echo '<span class="text-decoration-line-through">$'.$productPrice.'</span>';
            echo '<span>$'.$productPrice.'</span>';
            echo '</div>';
            echo '<p class="lead">'.$description.'</p>';
                
            
                
            }
        
        else {
            echo "0 results";
        }
        $conn->close();
    }
    
    ?>
        <?php
         function getRelatedProducts()
         {
            require("conn.php");

            $productID = htmlspecialchars($_GET["id"]);

            $sql = "SELECT * FROM `products` where product_category = (SELECT product_category from `products` where product_id = $productID ) && product_id != $productID ; ";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) 
            $row = $result->fetch_assoc();

            $productImage = $row['product_image'];
            $productName = $row['product_name'];
            $productPrice = $row['product_price'];

            echo '<div class="col mb-5">';
            echo '<div class="card h-100">';
            echo '<img class="card-img-top" src="'. $productImage .'" alt="..." />';
            echo '<div class="card-body p-4">';
            echo '<div class="text-center">';
            echo '<h5 class="fw-bolder">'. $productName .'</h5>';
            echo '<span class="text-muted text-decoration-line-through">'. $productPrice .'</span>';
            echo '</div>';
            echo '</div>';
            echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
            echo '<div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id='. $row['product_id']. '">View options</a></div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
                
            
                
            }
        
        else {
            echo "0 results";
        }
        $conn->close();
        }
    ?>
        <?php
         function checkStocks()
         {
             
            require("conn.php");

            $productID = htmlspecialchars($_GET["id"]);

            $sql = "SELECT product_quantity FROM `products` where product_id = $productID ; ";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) 
            $row = $result->fetch_assoc();

            $productQty = $row['product_quantity'];
            
                if ($productQty == 0)
                {
                    echo '<h3>Out of Stock!</h3>';
                }
                else
                {
                    echo '<div class="d-flex">';
                    echo '<input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />';
                    echo '<button name="addtocart" value="' . $productID .'"class="btn btn-outline-dark flex-shrink-0">Add to Cart</button>';
                }
                
            
                
            }
        
        else {
            echo "0 results";
        }
        $conn->close();
        }
    ?>
       
    </body>
</html>
