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

    <main class="container">
            <h1>Add Products</h1>
            
            <form action="adminproducts_add_p.php" method="post">
                <div class="form-group">
                <label for="p_name">Product Name:</label>
                <input class="form-control" type="text" id="p_name" required maxlength="45" name="p_name"
                       placeholder="Enter product name">
                </div>
                <div class="form-group">
                <label for="p_desc">Description:</label>
                <input class="form-control" type="text" id="p_desc" required maxlength="255" name="p_desc"
                       placeholder="Enter product description">
                </div>
                <div class="form-group">
                <label for="p_category">Category:</label>
                <input class="form-control" type="text" id="p_category" required maxlength="45" name="p_category"
                       placeholder="Enter category">
                </div>
                <div class="form-group">
                <label for="p_image">Image:</label>
                <input class="form-control" type="text" id="p_image" required maxlength="45" required name="p_image"
                       placeholder="Enter image link">
                </div>
                <div class="form-group">
                <label for="p_thumbnail">Image thumbnail:</label>
                <input class="form-control" type="text" id="p_thumbnail" required maxlength="45" required name="p_thumbnail"
                       placeholder="Enter thumbnail link">
                </div>
                <div class="form-group">
                <label for="p_price">Price:</label>
                <input class="form-control" type="number" step=0.01 id="p_price" required maxlength="11" required name="p_price"
                       placeholder="Enter price">
                </div>
                <div class="form-group">
                <label for="p_quantity">Quantity:</label>
                <input class="form-control" type="number" step=1 id="p_quantity" required maxlength="11" required name="p_quantity"
                       placeholder="Enter quantity">
                </div>
                <div class="form-group">
                <button class="btn btn-primary" type="submit" name="btnSubmit">Submit</button>
                </div>
            </form>
        </main>

   

</body>
