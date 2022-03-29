<!DOCTYPE HTML>

<html lang="en">
<main>
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


    <header class="bg-dark py-5">
        <div class="container">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Petshop 2.0 Admin Page</h1>
                <p class="lead fw-normal text-white-50 mb-0">Welcome back admin!</p>
                <p>
                    <a href="adminproducts.php" class="btn btn-primary my-2">View Products</a>
                </p>
                <p>
                    <a href="adminorders.php" class="btn btn-primary my-2">View Orders</a>
                </p>
                <p>
                    <a href="adminpromotions.php" class="btn btn-primary my-2">View Promotions</a>
                </p>
                <p>
                    <a href="adminusers.php" class="btn btn-primary my-2">View Users</a>
                </p>
            </div>
        </div>
    </header>

</body>
</main>
</html>