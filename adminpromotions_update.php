<!DOCTYPE HTML>

<head>
    <title>Update Promotion</title>
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
        <?php

        require("conn.php");
        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (isset($_POST['update'])) {
            $pid = $prod_id = $discount = 0;
            $sdate = $edate = "";
            $pid = sanitize_input((int)$_GET['promotion_id']);
            $prod_id = sanitize_input((int)$_POST['prod_id']);
            $discount = sanitize_input((int)$_POST['discount']);
            $sdate = sanitize_input((string)$_POST['sdate']);
            $edate = sanitize_input((string)$_POST['edate']);

            $stmt = $conn->prepare("UPDATE `promotions` SET `prod_id`=?,`discount`=?, `start_date`=?, `end_date`=? WHERE `promotion_id`=?");
            $pid = mysqli_real_escape_string($conn, $pid);
            $prod_id = mysqli_real_escape_string($conn, $prod_id);
            $discount = mysqli_real_escape_string($conn, $discount);
            $sdate = mysqli_real_escape_string($conn, $sdate);
            $edate = mysqli_real_escape_string($conn, $edate);
            // Bind & execute the query statement:
            $stmt->bind_param("iissi", $prod_id, $discount, $sdate, $edate, $pid);
            if (!$stmt->execute()) {
                echo '<script>';
                echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                echo 'window.location.href = "adminpromotions_update.php";';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'createCookie("succmessage", "Update success!", 1);';
                echo 'window.location.href = "adminpromotions.php";';
                echo '</script>';
            }
            $stmt->close();
        }

        if (isset($_GET['promotion_id'])) {
            $pid = $prod_id = 0;
            $prod_name = "";
            $pid = $_GET['promotion_id'];
            $conn = new mysqli(
                $config["servername"],
                $config["username"],
                $config["password"],
                $config["dbname"]
            );
            $stmt = $conn->prepare("SELECT * FROM `promotions` WHERE promotion_id=?;");
            $pid = mysqli_real_escape_string($conn, $pid);
            $stmt->bind_param("d", $pid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $promotion_id = $row['promotion_id'];
                $prod_id = $row['prod_id'];
                $discount = $row['discount'];
                $sdate = $row['start_date'];
                $edate = $row['end_date'];
            }
            $stmt = $conn->prepare("SELECT * FROM `products`;");
            $prod_id = mysqli_real_escape_string($conn, $prod_id);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>

            <h1>Update Promotion</h1>

            <form action="" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="promotion_id">Promotion ID:</label>
                        <input class="form-control" type="number" name="promotion_id" value="<?php echo $promotion_id; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="prod_id">Product:</label><br>
                        <?php
                        if ($result->num_rows > 0) {
                            echo '<select name="prod_id">';
                            while ($row = $result->fetch_assoc()) {
                                if ($row['product_id'] == $prod_id) {
                                    echo '<option selected value="' . $row['product_id'] . '">' . $row['product_name'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['product_id'] . '">' . $row['product_name'] . '</option>';
                                }
                            }
                            echo '</select>';
                        } else {
                            echo "There are no existing products.";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount: <span id="discountval"><?php echo $discount ?></span>%</label>
                        <input class="form-range" type="range" id="discount" required min="1" max="99" name="discount" value="<?php echo $discount ?>">
                    </div>
                    <div class="form-group">
                        <label for="discount">Start Date:</label>
                        <input class="form-control date" type="date" name="sdate" value="<?php echo $sdate; ?>">
                    </div>
                    <div class="form-group">
                        <label for="discount">End Date:</label>
                        <input class="form-control date" type="date" name="edate" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $edate; ?>">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" value="update" name="update">Submit</button>
                    </div>
                </fieldset>
            </form>
            <div>
                <p id="errormsg">
                </p>
            </div>
            <script>
                var errormsg = getCookie("errorMsg");
                if (errormsg == null) {
                    errormsg = " ";
                }
                document.getElementById('errormsg').innerHTML += errormsg;
            </script>
</body>

</html>

<?php
        } else {
            header('Location: adminpromotions.php');
        }
?>
</main>


</body>