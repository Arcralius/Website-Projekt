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

    <?php
		require("conn.php");

		/**$sql = "SELECT * FROM products";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		  // output data of each row
		  while($row = $result->fetch_assoc()) {
			echo "id: " . $row["product_id"] . " - desc: " . $row["product_name"] . " " . $row["product_price"] . $row["product_quantity"]. "<br>";
		  }
		} else {
		  echo "0 results";
		}
		$conn->close();**/

		$sql = "SELECT * FROM products";
		$result = $conn->query($sql);

	?> 

	<div class="container">
    <p>
        <a href="adminproducts_add.php" class="btn btn-primary my-2">Add products</a>
    </p>
        <h2>Products</h2>
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

                        <td><a class="btn btn-info" href="adminproducts_update.php?product_id=<?php echo $row['product_id']; ?>">Edit</a>&nbsp;<a class="btn btn-danger" href="adminproducts_delete.php?product_id=<?php echo $row['product_id']; ?>">Delete</a></td>
                        </tr>   
            <?php       }
                }
            ?>
        </tbody>
    </table>
    </div>
   

</body>