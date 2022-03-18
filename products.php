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

    <h1 class="mb-3" id="productspageheading">Products</h1>
    <div class="album py-3 bg-white">
        <div class="container">
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

        if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) 
            while($row = $result->fetch_assoc())
            {
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