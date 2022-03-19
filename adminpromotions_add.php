<!DOCTYPE HTML>

<head>
    <title>Add Promotions</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
    <?php
    include 'navbar.php';
    include 'adminsession.php';
    ?>
    

    <main class="container">
            <h1>Add Promotions</h1>
            
            <form action="adminpromotions_add_p.php" method="post">
                <div class="form-group">
                <label for="prod_id">Product ID:</label>
                <input class="form-control" type="number" step=1 id="prod_id" required maxlength="20" name="prod_id"
                       placeholder="Enter product id">
                </div>
                <div class="form-group">
                <label for="discount">Discount:</label>
                <input class="form-control" type="number" step=1 id="discount" required maxlength="11" name="discount"
                       placeholder="Enter discount">
                </div>
                <div class="form-group">
                <button class="btn btn-primary" type="submit" name="btnSubmit">Submit</button>
                </div>
            </form>
        </main>

   

</body>
