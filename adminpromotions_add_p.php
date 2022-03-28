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
    ?>

    <main class="container">
        <?php
        $prod_id = $discount = $errorMsg = $success = $sdate = $edate = "";
        $success = true;
        if (empty($_POST["prod_id"])) {
            $errorMsg .= "Product id is required.<br>";
            $success = false;
        } else {
            $prod_id = sanitize_input($_POST["prod_id"]);
        }

        if (empty($_POST["discount"])) {
            $errorMsg .= "Discount is required.<br>";
            $success = false;
        } else {
            $discount = sanitize_input($_POST["discount"]);
        }

        if (empty($_POST["sdate"])) {
            $errorMsg .= "Starting date is required.<br>";
            $success = false;
        } else {
            $sdate = sanitize_input($_POST["sdate"]);
        }

        if (empty($_POST["edate"])) {
            $errorMsg .= "End date is required.<br>";
            $success = false;
        } else {
            $edate = sanitize_input($_POST["edate"]);
        }

        if ($sdate > $edate) {
            $errorMsg .= "The starting date cannot be after the end date.<br>";
            $success = false;
        }

        checkPromo();

        if ($success) {
            savePromotionToDB();
        }

        if ($success) {
            echo '<script>';
            echo 'createCookie("succmessage", "Addtion success!", 1);';
            echo 'window.location.href = "adminpromotions.php";';
            echo '</script>';
        } else {
            echo '<script>';
            echo 'createCookie("errorMsg", "Product not avaliable", 1);';
            echo 'window.location.href = "adminpromotions_add.php";';
            echo '</script>';
        }

        //Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        function savePromotionToDB()
        {
            global $prod_id, $discount, $sdate, $edate, $errorMsg, $success;
            // Create database connection.
            /**$config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'],
                    $config['password'], $config['dbname']);**/
            require("conn.php");
            // Check connection
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {
                // Prepare the statement:
                $prod_id = mysqli_real_escape_string($conn, $prod_id);
                $discount = mysqli_real_escape_string($conn, $discount);
                $sdate = mysqli_real_escape_string($conn, $sdate);
                $edate = mysqli_real_escape_string($conn, $edate);
                $stmt = $conn->prepare("INSERT INTO promotions (prod_id, discount, start_date, end_date) VALUES (?, ?, ?, ?)");
                // Bind & execute the query statement:
                $stmt->bind_param("iiss", $prod_id, $discount, $sdate, $edate);
                if (!$stmt->execute()) {
                    $errorMsg = "Product not found";
                    $success = false;
                } else {
                    $success = true;
                }
                $stmt->close();
            }
            $conn->close();
        }

        function checkPromo()
        {
            global $prod_id, $sdate, $edate, $errorMsg, $success;
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
                        if (($row['start_date']  <= $sdate && $row['end_date'] >= $sdate) || ($row['start_date']  <= $edate && $row['end_date'] >= $edate)) {
                            $errorMsg .= "<p>An existing promotion for that product is already in the date range specified.</p>";
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

</body>