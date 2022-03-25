<!DOCTYPE HTML>

<head>
    <title>Admin Home Page</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
    <?php
    include 'navbar.php';
    include 'adminsession.php';
    ?>


    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Petshop 2.0 Admin Page</h1>
            <p class="lead text-muted">Welcome back admin!</p>
            <p>
                <a href="adminproducts.php" class="btn btn-primary my-2">View Products</a>
            </p>
            <p>
                <a href="adminorders.php" class="btn btn-primary my-2">View Orders</a>
            </p>
            <p>
                <a href="adminpromotions.php" class="btn btn-primary my-2">View Promotions</a>
            </p>
        </div>
    </section>

</body>