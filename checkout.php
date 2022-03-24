<!DOCTYPE HTML>

<head>
    <title>Checkout</title>
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
            <h1 class="jumbotron-heading">Cart</h1>
        </div>
    </section>

    <div class="album py-3 bg-white">
        <div class="container" id="products">
            <section>
                    <?php
                    if (isset($_SESSION["role"])) {
                        echo '<div class="carttable"></div>';
                        //getCart();
                    } else
                        echo "You must be signed in to access your cart.";
                    ?>
            </section>
        </div>
    </div>
</body>