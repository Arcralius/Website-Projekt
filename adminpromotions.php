<!DOCTYPE HTML>
<html lang="en">
    <head>
        <?php
        include 'header.php';
        ?>
    </head>

    <body>
        <?php
        include 'navbar.php';
        include 'adminsession.php';
        ?>
        <main>
            <?php
            require("conn.php");
            $sql = "SELECT * FROM promotions";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            ?>

            <div class="container">
                <p>
                    <a href="adminpromotions_add.php" class="btn btn-primary my-2">Add promotions</a>
                </p>
                <h1>Promotions</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Promotion ID</th>
                            <th>Product</th>
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th></th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $prodName = "";
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $conn2 = new mysqli(
                                    $config["servername"],
                                    $config["username"],
                                    $config["password"],
                                    $config["dbname"]
                                );
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
                        ?>
                                <td>
                                    <div class="col-sm-12 text-center">
                                        <?php
                                            echo '<form action="adminpromotions_update.php" method="post">';
                                            echo '<input type="hidden" name="promotion_id" value="' . $row['promotion_id'] . '">';
                                            echo '<button type="submit" class="btn btn-info btn-md" style=" width: 100px;  display: inline-block; vertical-align: top;">Edit</button>';
                                            echo '</form>';
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12 text-center">
                                        <?php
                                            echo '<form action="adminpromotions_delete.php" method="post">';
                                            echo '<input type="hidden" name="promotion_id" value="' . $row['promotion_id'] . '">';
                                            echo '<button type="submit" class="btn btn-danger btn-md" style=" width: 100px; display: inline-block; vertical-align: top;" >Delete</button>';
                                            echo '</form>';
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
                <div class = "center text-center">
                    <p id="succmessage">
                    </p>
                    <p id="errormsg">
                    </p>
                </div>
            </div>
        </main>
        <?php include 'footer.php';?>
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
</html>