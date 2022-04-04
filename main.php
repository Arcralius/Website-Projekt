<!DOCTYPE HTML>
<html lang="en">
    <head>
        <?php
        include 'header.php';
        ?>
    </head>
    <body>
        <?php
        include 'navbar.php';
        ?>
        <main>
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
        </main>
        <?php include "footer.php" ?>
    </body>
</html>

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
            $discount = checkPromo($row['product_id']);
            if ($discount != NULL)
            {
                echo '<span class="text-muted text-decoration-line-through">$' . $row['product_price'] . '</span>';
                echo '<span class="text"> $' . number_format($row['product_price'] * $discount, 2) . '</span>';
            }
            else {
                echo '<span class="text">$' . $row['product_price'] . '</span>';
            }
            echo '</div>';
            echo '</div>';
            echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
            echo '<form action="product.php" method="post">';
            echo '<input type="hidden" name="productID" value="'.$row['product_id'].'">';
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
            $discount = checkPromo($row['product_id']);
            if ($discount != NULL)
            {
                echo '<span class="text-muted text-decoration-line-through">$' . $row['product_price'] . '</span>';
                echo '<span class="text"> $' . number_format($row['product_price'] * $discount, 2) . '</span>';
            }
            else {
                echo '<span class="text">$' . $row['product_price'] . '</span>';
            }
            echo '</div>';
            echo '</div>';
            echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
            echo '<form action="product.php" method="post">';
            echo '<input type="hidden" name="productID" value="'.$row['product_id'].'">';
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
    }
    else {
        $discount2 = NULL;
    }
    $stmt->close();
    $conn->close();
    return $discount2;
}
?>