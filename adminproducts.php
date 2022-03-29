<!DOCTYPE HTML>
<html lang="en">
    <main>
<head>
    <title>Products</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
    <?php
    include 'navbar.php';
    include 'adminsession.php';
    ?>

    <?php

    require("conn.php");


    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result

    ?>

    <div class="container">
        <p>
            <a href="adminproducts_add.php" class="btn btn-primary my-2">Add products</a>
        </p>
        <h1>Products</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Image Link</th>
                    <th>Thumbnail Link</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>

                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['product_desc']; ?></td>
                    <td><?php echo $row['product_category']; ?></td>
                    <td><?php echo $row['product_image']; ?></td>
                    <td><?php echo $row['product_thumbnail']; ?></td>
                    <td><?php echo $row['product_price']; ?></td>
                    <td><?php echo $row['product_quantity']; ?></td>
                    <td>
                        <div class="col-sm-12 text-center">
                            <?php
                            echo '<form action="adminproducts_update.php" method="post">';
                            echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
                            echo '<button type="submit" class="btn btn-info btn-md" style=" width: 100px;  display: inline-block; vertical-align: top;">Edit</button>';
                            echo '</form>';
                            ?>
                    </td>
                    <td>
                        <?php
                        echo '<form action="adminproducts_delete.php" method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
                        echo '<button type="submit" class="btn btn-danger btn-md" style=" width: 100px; display: inline-block; vertical-align: top;" >Delete</button>';
                        echo '</form>';
                        ?>
                        </div>
                    </td>
                </tr>
<?php       }
                }
?>
</tbody>
</table>

<div>
    <p id="succmessage">
    </p>
    <p id="errormsg">
    </p>
</div>

</div>

<script>
    var succmessage = getCookie("succmessage");
    if (succmessage == null) {
        succmessage = " ";
    }
    document.getElementById('succmessage').innerHTML += succmessage;

    var errormsg = getCookie("errorMsg");
    if (errormsg == null) {
        errormsg = " ";
    }
    document.getElementById('errormsg').innerHTML += errormsg;
</script>

</body>
</main>
</html>