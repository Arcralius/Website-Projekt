<!DOCTYPE HTML>
<html lang="en">
<main>

    <head>
        <title>Payment</title>
        <?php
        include 'header.php';
        ?>
    </head>

    <body>
        <?php
        include 'navbar.php';
        ?>
        
        <div class="album py-3 bg-white">
            <div class="container" id="payment">
                <section>
                    <?php
                        confirmPayment();
                    ?>
                </section>
            </div>
        </div>
    </body>
</main>
<?php
    include 'footer.php';
    $ord_id = $prod_id = $user_id = $total_price = $discountCost = 0;
    $username = $shipment_date = $errorMsg = $success = $expiry = "";
    
    $success = true;
    function confirmPayment(){
        global $ord_id, $prod_id, $username, $user_id, $total_price, $shipment_date, $errorMsg, $success;
        $validated = true;
        if (!empty($_SESSION["cart"])) {
            if (empty($_SESSION["username"])) {
                $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: PAYMENT ERROR 1<br>";
                $validated = false;
            } else {
                $username = sanitize_input($_SESSION["username"]);
            }
            $user_id = getUID($username);
            if ($user_id==-1) {
                $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: PAYMENT ERROR 2<br>";
                $validated = false;
            } else if ($user_id==0) {
                $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: PAYMENT ERROR 3<br>";
                $validated = false;
            }
            
            $expiry = getExpiry($user_id);
            if ($expiry != -1) {
                if ($expiry < date("Y-m-d")) {
                    $errorMsg .= "Your card is past the expiry date.";
                    $validated = false;
                }
            } else {
                $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: PAYMENT ERROR 4<br>";
                $validated = false;
            }
            $ord_id = getOID();
            $shipment_date = date("Y-m-d", strtotime(date("Y-m-d"). ' + 5 days'));
            
            foreach($_SESSION["cart"] as $prod) {
                if (empty($prod[4]) || empty($prod[6])) {
                    $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: PAYMENT ERROR 5<br>";
                    $validated = false;
                } else {
                    $discountCost = $prod[4] * (100 - $prod[5])/100;
                    $total_price += $discountCost * $prod[6];
                }
            }
            foreach($_SESSION["cart"] as $prod) {
                if (empty($prod[0])) {
                    $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: PAYMENT ERROR 6<br>";
                    $validated = false;
                } else {
                    $prod_id = sanitize_input($prod[0]);
                }

                if ($validated) {
                    insertOrder();
                } else {
                    $success = false;
                }
            }
            if ($success) {
                echo "<main class='container'>";
                echo "<div class='col' align='center'>";
                echo "<h1>Payment successful!<br></h1>";
                echo "<h2>Order ID: " . $ord_id . "</h2>";
                echo "<h2>Shipment Date: " . $shipment_date . "</h2>";
                echo "<form action='main.php'>";
                echo "<button class='btn btn-success'>Return to Home</button>";
                echo "</form>";
                echo "</div>";
                echo "</main>";
                unset($_SESSION['cart']);
                echo "<script>updateNavCart(0);</script>";
            } else {
                echo '<script>';
                echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
                echo 'window.location.href = "payment.php";';
                echo '</script>';
            }
        }
    }
    
    function getUID($uname) {
        $uid = 0;
        $config = parse_ini_file("../../private/db-config.ini");
        $conn = new mysqli($config["servername"], $config["username"],
            $config["password"], $config["dbname"]);
        $username = mysqli_real_escape_string($conn, $uname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE username=?;");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $uid = $row['user_id'];
            } else {
                $uid = -1;
            }
            $stmt->close();
        }
        $conn->close();
        return $uid;
    }
    
    function getOID() {
        $oid = 0;
        $config = parse_ini_file("../../private/db-config.ini");
        $conn = new mysqli($config["servername"], $config["username"],
            $config["password"], $config["dbname"]);
        if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT * FROM `orders` ORDER BY order_id DESC;");
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $oid = $row['order_id'] + 1;
            } else {
                $oid = 1;
            }
            $stmt->close();
        }
        $conn->close();
        return $oid;
    }
    
    function getExpiry($user_id) {
        $config = parse_ini_file("../../private/db-config.ini");
        $conn = new mysqli($config["servername"], $config["username"],
            $config["password"], $config["dbname"]);
        $uid = mysqli_real_escape_string($conn, $user_id);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT * FROM `payment_details` WHERE user_id=?;");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $expiry = $row['expiration'];
            } else {
                $expiry = -1;
            }
            $stmt->close();
        }
        $conn->close();
        return $expiry;
    }
    
    function insertOrder() {
        global $ord_id, $prod_id, $user_id, $total_price, $shipment_date, $errorMsg, $success;
        $config = parse_ini_file("../../private/db-config.ini");
        $conn = new mysqli($config["servername"], $config["username"],
        $config["password"], $config["dbname"]);
        if ($conn->connect_error) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        } else {
            // Prepare the statement:
            $ord_id = mysqli_real_escape_string($conn, $ord_id);
            $prod_id = mysqli_real_escape_string($conn, $prod_id);
            $user_id = mysqli_real_escape_string($conn, $user_id);
            $total_price = mysqli_real_escape_string($conn, $total_price);
            $shipment_date = mysqli_real_escape_string($conn, $shipment_date);
            $stmt = $conn->prepare("INSERT INTO orders (order_id, pid, uid, total_price, shipment_date) VALUES (?, ?, ?, ?, ?)");
            // Bind & execute the query statement:
            $stmt->bind_param("iiids", $ord_id, $prod_id, $user_id, $total_price, $shipment_date);
            if (!$stmt->execute()) {
                $errorMsg = "Something has gone wrong. Please contact a System Administrator with the following information: PAYMENT ERROR 6<br>". $stmt->errno ;
                $success = false;
            } else {
                $success = true;
            }
            $stmt->close();
        }
        $conn->close();
    }
    
    function sanitize_input($data) 
    {   
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

