<!DOCTYPE HTML>

<head>
    <title>Promotions</title>
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


		$sql = "SELECT * FROM promotions";
		$result = $conn->query($sql);

	?> 
    
	<div class="container">
    <p>
        <a href="adminpromotions_add.php" class="btn btn-primary my-2">Add promotions</a>
    </p>
        <h2>Promotions</h2>
    <table class="table">
        <thead>
            <tr>
            <th>Promotion ID</th>
            <th>Product ID</th>
            <th>Discount</th>
        </tr>
        </thead>
        <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
            ?>
            
                        <tr>
                        <td><?php echo $row['promotion_id']; ?></td>
                        <td><?php echo $row['prod_id']; ?></td>
                        <td><?php echo $row['discount']; ?></td>

                        <td><a class="btn btn-info" href="adminpromotions_update.php?promotion_id=<?php echo $row['promotion_id']; ?>">Edit</a>&nbsp;<a class="btn btn-danger" href="adminpromotions_delete.php?promotion_id=<?php echo $row['promotion_id']; ?>">Delete</a></td>
                        </tr>
            <?php       }
                }
            ?>
        </tbody>
    </table>
    </div>
   

</body>