<!DOCTYPE HTML>
<html lang="en">
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
            $pid = $prod_id = $discount = 0;
            $sdate = $edate = $errorMsg = "";
            $success = true;
            
            function sanitize_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            
            if (isset($_POST['update'])) {
                global $pid, $prod_id, $dicount, $sdate, $edate;
                $pid = sanitize_input((int)$_POST['promotion_id']);
                $prod_id = sanitize_input((int)$_POST['prod_id']);
                $discount = sanitize_input((int)$_POST['discount']);
                $sdate = sanitize_input((string)$_POST['sdate']);
                $edate = sanitize_input((string)$_POST['edate']);
                
                checkPromo();
                
                if ($success) {
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
                } else {
                    echo '<script>';
                    echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                    echo 'window.location.href = "adminpromotions_update.php";';
                    echo '</script>';
                }
            }
            
            function checkPromo()
            {
                global $pid, $prod_id, $sdate, $edate, $errorMsg, $success;
                require("conn.php");
                $conn = new mysqli(
                    $config["servername"],
                    $config["username"],
                    $config["password"],
                    $config["dbname"]
                );
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    $stmt = $conn->prepare("SELECT * FROM promotions WHERE prod_id=?");
                    $stmt->bind_param("i", $prod_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ((($row['start_date']  <= $sdate && $row['end_date'] >= $sdate) || ($row['start_date']  <= $edate && $row['end_date'] >= $edate)) && $pid != $row['promotion_id']) {
                                $errorMsg .= "An existing promotion for that product is already in the date range specified.";
                                $success = false;
                            }
                        }
                    }
                    $stmt->close();
                }
                $conn->close();
                return;
            }
            ?>
        </main>
        <?php include 'footer.php';?>
    </body>
</html>