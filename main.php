<!DOCTYPE HTML>

<head>
    <title>test</title>
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

    <div class="album py-3 bg-light">
        <div class="container">
            <section id="products">
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
        $servername = "localhost";
        $username = "arcralius";
        $password = "password";
        $dbname = "worldofpetsv2";


        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM `products`; ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) 
            for ($i = 0; $i < 3; $i++) {
                $row = $result->fetch_assoc();

                echo '<div class="col-md-4">';
                echo '<a href="product.php?id=' . $row['product_id'] . '">';
                echo '<div class="card mb-4 box-shadow">';
                echo '<img class="card-img-top" src=' . $row['product_image'] . ' alt="Card image cap">';
                echo '<div class="card-body">';
                echo '<p class="card-text">' . $row['product_name'] . '</p>';
                echo '<div class="d-flex justify-content-between align-items-center">';
                echo '<small class="text-muted">$' . $row['product_price'] . '</small>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    ?>


</body>