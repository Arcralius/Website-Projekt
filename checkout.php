<!DOCTYPE HTML>
<html lang="en">
<main>

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
        
        <div class="album py-3 bg-white">
        
            <div class="container" id="products">
                <section>
                <h1>Checkout</h1>
                    <?php
                    if (isset($_SESSION["role"])) {
                        echo '<div class="carttable"></div>';
                    } else
                        echo "You must be signed in to access your cart.";
                    ?>
                </section>
            </div>
        </div>
    </body>
</main>
<?php include 'footer.php';?>

</html>