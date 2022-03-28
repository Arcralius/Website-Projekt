<!DOCTYPE HTML>

<head>
    <title>Orders</title>
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


    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);

    ?>

    <div class="container">
        <p>
            <a href="adminorders_add.php" class="btn btn-primary my-2">Add orders</a>
        </p>
        <h2>Orders</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product ID</th>
                    <th>User ID</th>
                    <th>Shipment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>

                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['pid']; ?></td>
                            <td><?php echo $row['uid']; ?></td>
                            <td><?php echo $row['shipment_date']; ?></td>

                            <td><a class="btn btn-info" href="adminorders_update.php?order_id=<?php echo $row['order_id']; ?>">Edit</a>&nbsp;<a class="btn btn-danger" href="adminorders_delete.php?order_id=<?php echo $row['order_id']; ?>">Delete</a></td>
                        </tr>
                <?php       }
                }
                ?>
            </tbody>
        </table>
        <div>
            <p id="succmessage">
            </p>
        </div>
    </div>

    <script>
        var succmessage = getCookie("succmessage");
        if (succmessage == null) {
            succmessage = " ";
        }
        document.getElementById('succmessage').innerHTML += succmessage
    </script>


</body>