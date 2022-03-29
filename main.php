<!DOCTYPE HTML>
<html lang="en">
<main>
<head>
    
    <?php
    include 'header.php';
    ?>
</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Petshop 2.0</h1>
            <p class="lead text-muted">Welcome to petshop 2.0</p>
            <p>
                <a href="main.php#products" class="btn btn-primary my-2">Start Shopping</a>
            </p>
        </div>
    </section>

    <div class="album py-3 bg-white">
        <div class="container" id="products">
            <section>
                <div class="row">
                    <?php
                    printproducts();
                    ?>
                </div>
            </section>
        </div>
    </div>
    <?php
    function printproducts()
    {
        $config = parse_ini_file("../../private/db-config.ini");
        $conn = new mysqli($config["servername"], $config["username"],
            $config["password"], $config["dbname"]);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM `products`; ";
        $result = $conn->query($sql);

        if ($result -> num_rows == 0 ) {
            echo "0 results";
        }
        if ($result->num_rows < 3) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-6 col-md-6 col-lg-4 mb-3">';
                echo '<div class="card h-100">';
                echo '<img class="card-img-top" src="' . $row['product_image'] . '" alt="' . $row['product_desc'] . '" />';
                echo '<div class="card-body p-4">';
                echo '<div class="text-center">';
                echo '<p class="fw-bolder">' . $row['product_name'] . '</p>';
                echo '<span class="text-muted text-decoration-line-through">$' . $row['product_price'] . '</span>';
                echo '</div>';
                echo '</div>';
                echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                echo '<form action="product.php" method="post">';
                echo '<input type="hidden" name="productID" value="'.$row['product_id'].'">';
                // echo '<div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id=' . $productID . '">View options</a></div>';
                echo '<button type="submit" class="form-control btn btn-outline-dark rounded submit px-3">View Details</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) 
            for ($i = 0; $i < 3; $i++) {
                $row = $result->fetch_assoc();

                echo '<div class="col-6 col-md-6 col-lg-4 mb-3">';
                echo '<div class="card h-100">';
                echo '<img class="card-img-top" src="' . $row['product_image'] . '" alt="' . $row['product_desc'] . '" />';
                echo '<div class="card-body p-4">';
                echo '<div class="text-center">';
                echo '<p class="fw-bolder">' . $row['product_name'] . '</p>';
                echo '<span class="text-muted text-decoration-line-through">$' . $row['product_price'] . '</span>';
                echo '</div>';
                echo '</div>';
                echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                echo '<form action="product.php" method="post">';
                echo '<input type="hidden" name="productID" value="'.$row['product_id'].'">';
                // echo '<div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id=' . $productID . '">View options</a></div>';
                echo '<button type="submit" class="form-control btn btn-outline-dark rounded submit px-3">View Details</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }
    ?>

</body>
</main>
</html>