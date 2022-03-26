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
    
    require("conn.php");
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    ?>
    

    <main class="container">
        <h1>Add Promotions</h1>

        <form action="adminpromotions_add_p.php" method="post">
            <div class="form-group">
                <label for="prod_id">Product:</label><br>
                <?php
                    if ($result->num_rows > 0) {
                        echo '<select name="prod_id">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['product_id'] . '">' . $row['product_name'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "There are no existing products.";
                    }
                ?>
            </div>
            <div class="form-group">
                <label for="discount">Discount: <span id="discountval">1</span>%</label>
                <input class="form-range" type="range" id="discount" required min="1" max="99" name="discount" value="1">
            </div>
            <div class="form-group">
                <label for="discount">Start Date:</label>
                <input class="form-control date" type="date" name="sdate" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>">
            </div>
            <div class="form-group">
                <label for="discount">End Date:</label>
                <input class="form-control date" type="date" name="edate" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="btnSubmit">Submit</button>
            </div>
        </form>
    </main>
</body>
