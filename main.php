<!DOCTYPE HTML>

<head>
    <title>test</title>
    <?php
    include 'header.php';
    include 'navbar.php'
    ?>
</head>

<body>
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Petshop 2.0</h1>
            <p class="lead text-muted">Welcome to petshop 2.0</p>
            <p>
                <a href="main.php#products" class="btn btn-primary my-2">Start Shopping</a>
            </p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <section id="products">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="https://www.cdc.gov/healthypets/images/pets/cute-dog-headshot.jpg" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">Placeholder.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                    </div> -->
                                    <small class="text-muted">$69.99</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="https://www.cdc.gov/healthypets/images/pets/cute-dog-headshot.jpg" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">Placeholder.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                    </div> -->
                                    <small class="text-muted">$69.99</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>