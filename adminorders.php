<!DOCTYPE HTML>

<html lang="en">
<main>

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
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        ?>

        <div class="container">
            <p>
                <a href="adminorders_add.php" class="btn btn-primary my-2">Add orders</a>
            </p>
            <h1>Orders</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>User ID</th>
                        <th>Total Price</th>
                        <th>Shipment Date</th>
                        <th>Quantity</th>
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
                                <td><?php echo $row['total_price']; ?></td>
                                <td><?php echo $row['shipment_date']; ?></td>
                                <td><?php echo $row['qty']; ?></td>

                                <td>
                                    <div class="col-sm-12 text-center">
                                        <?php
                                        echo '<form action="adminorders_update.php" method="post">';
                                        echo '<input type="hidden" name="order_id" value="' . $row['order_id'] . '">';
                                        echo '<input type="hidden" name="pid" value="' . $row['pid'] . '">';
                                        echo '<input type="hidden" name="uid" value="' . $row['uid'] . '">';
                                        echo '<button type="submit" class="btn btn-info btn-md" style=" width: 100px;  display: inline-block; vertical-align: top;">Edit</button>';
                                        echo '</form>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<form action="adminorders_delete.php" method="post">';
                                        echo '<input type="hidden" name="order_id" value="' . $row['order_id'] . '">';
                                        echo '<input type="hidden" name="pid" value="' . $row['pid'] . '">';
                                        echo '<input type="hidden" name="uid" value="' . $row['uid'] . '">';
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
            document.getElementById('succmessage').innerHTML += succmessage
            var errorMsg = getCookie("errorMsg");
            if (errorMsg == null) {
                errorMsg = " ";
            }
            document.getElementById('errormsg').innerHTML += errorMsg
        </script>


    </body>
</main>

</html>