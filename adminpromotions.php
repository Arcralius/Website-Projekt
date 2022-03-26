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
            <th>Product</th>
            <th>Discount</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $prodName = "";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $conn2 = new mysqli($config["servername"], $config["username"],
                            $config["password"], $config["dbname"]);
                        $stmt = $conn2->prepare("SELECT product_name FROM `products` WHERE product_id=?;");
                        $pid = mysqli_real_escape_string($conn2, $row['prod_id']);
                        $stmt->bind_param("d", $pid);
                        $stmt->execute();
                        $result2 = $stmt->get_result();
                        if ($result2->num_rows > 0) {
                            $row2 = $result2->fetch_assoc();
                            $prodName = $row2['product_name'];
                        }
                        
                        echo '<tr>';
                        echo '<td>' . $row['promotion_id'] . '</td>';
                        echo '<td>' . $prodName . '</td>';
                        echo '<td>' . $row['discount'] . '%</td>';
                        echo '<td>' . $row['start_date'] . '</td>';
                        echo '<td>' . $row['end_date'] . '</td>';
                        if ($row['start_date']  <= date("Y-m-d") && $row['end_date'] >= date("Y-m-d")) {
                            echo '<td>Active</td>';
                        } else {
                            echo '<td>Inactive</td>';
                        }
                        echo '<td>';
                        echo '<a class="btn btn-info" href="adminpromotions_update.php?promotion_id=' . $row['promotion_id'] . '">Edit</a>';
                        echo '&nbsp';
                        echo '<a class="btn btn-danger" href="adminpromotions_delete.php?promotion_id=' . $row['promotion_id'] . '">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
            ?>
        </tbody>
    </table>
    </div>
   

</body>