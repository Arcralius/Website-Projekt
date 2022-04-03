<!DOCTYPE HTML>
<html lang="en">
<main>

    <head>
        <title>Order History</title>
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
                <h1>Order History</h1>
                    <?php
                    if (isset($_SESSION["role"])) {
                        echo '<div class="ordertable"></div>';
                    } else
                        echo "You must be signed in to view your order history.";
                    ?>
                </section>
            </div>
        </div>
    </body>
</main>
<?php include 'footer.php';?>

</html>