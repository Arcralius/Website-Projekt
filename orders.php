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
        ?>
        <main>
            <div class="album py-3 bg-white">
                <div class="container" id="products">
                    <section>
                    <h1 class='text-center'>Order History</h1>
                        <?php
                        if (isset($_SESSION["role"])) {
                            getOrders();
                        } else
                            echo "<div class='center text-center'><h2>You must be signed in to view your order history.</h2></div>";
                        ?>
                    </section>
                </div>
            </div>
            <div class = "center text-center">
                <p id="errormsg"></p>
            </div>
        </main>
        <?php include 'footer.php';?>
    </body>
</html>

<?php 
    function getOrders() {
        $user_id = $price = $curr_oid = $buffcount = $count = $resultsCount = 0;
        $username = $errorMsg = $shipdate = $pname = "";
        $success = $validated = true;
        $products = $pbuff = array();
        if (empty($_SESSION["username"])) {
            $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: HISTORY ERROR 1<br>";
            $validated = false;
        } else {
            $username = sanitize_input($_SESSION["username"]);
        }
        $user_id = getUID($username);
        if ($user_id==-1) {
            $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: HISTORY ERROR 2<br>";
            $validated = false;
        } else if ($user_id==0) {
            $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: HISTORY ERROR 3<br>";
            $validated = false;
        }

        if ($validated) {
            $config = parse_ini_file("../../private/db-config.ini");
            $conn = new mysqli($config["servername"], $config["username"],
                $config["password"], $config["dbname"]);
            $user_id = mysqli_real_escape_string($conn, $user_id);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: HISTORY ERROR 4<br>";
                $success = false;
            } else {
                $stmt = $conn->prepare("SELECT * FROM `orders` WHERE uid=?;");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $resultsCount = mysqli_num_rows($result);
                if ($result->num_rows > 0) {
                    echo '<table class="table cart">';
                    echo '<thead><tr>';
                    echo '<th class="align-middle text-center">Order ID</th>';
                    echo '<th class="align-middle text-center">Products</th>';
                    echo '<th class="align-middle text-center">Total</th>';
                    echo '<th class="align-middle text-center">Shipment Date</th>';
                    echo '</tr></thead>';
                    while ($row = $result->fetch_assoc()){
                        if (($curr_oid == intval($row["order_id"]))) {
                            array_push($pbuff,$row["pid"]);
                        } else {
                            if ($buffcount != 0) {
                                echo '<tr>';
                                echo '<td class="align-middle text-center">' . $curr_oid . '</td>';
                                echo '<td class="align-middle text-center">';
                                foreach ($pbuff as $p) {
                                    $pname = getProd($p);
                                    if ($pname != NULL)
                                        echo getProd($p) . "<br>";
                                }
                                echo '</td>';
                                echo '<td class="align-middle text-center">$' . $price . '</td>';
                                echo '<td class="align-middle text-center">' . $shipdate . '</td>';
                                echo '</tr>';
                            }
                            $price = $row["total_price"];
                            $shipdate = $row["shipment_date"];
                            $buffcount = 0;
                            $pbuff = array($row["pid"]);
                        }
                        $buffcount += 1;
                        $count += 1;
                        $curr_oid = intval($row["order_id"]);
                        if ($count == $resultsCount) {
                            echo '<tr>';
                            echo '<td class="align-middle text-center">' . $row["order_id"] . '</td>';
                            echo '<td class="align-middle text-center">';
                            foreach ($pbuff as $p) {
                                $pname = getProd($p);
                                if ($pname != NULL)
                                    echo getProd($p) . "<br>";
                            }
                            echo '</td>';
                            echo '<td class="align-middle text-center">$' . $row["total_price"] . '</td>';
                            echo '<td class="align-middle text-center">' . $row["shipment_date"] . '</td>';
                            echo '</tr>';
                        }
                    }
                    echo '</table>';
                } else {
                    echo "You currently have no past orders.";
                }
                $stmt->close();
            }
            $conn->close();
        } else {
            $errorMsg .= "Something has gone wrong. Please contact a System Administrator with the following information: HISTORY ERROR 5<br>";
            $success = false;
        }
        if (!$success) {
            echo '<script>';
            echo 'createCookie("errorMsg", "' . $errorMsg . '", 1);';
            echo 'window.location.href = "orders.php";';
            echo '</script>';
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
    
    function getProd($pid) {
        $pname = "";
        $config = parse_ini_file("../../private/db-config.ini");
        $conn = new mysqli($config["servername"], $config["username"],
            $config["password"], $config["dbname"]);
        $pid = mysqli_real_escape_string($conn, $pid);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT * FROM `products` WHERE product_id=?;");
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pname = $row['product_name'];
            } else {
                $pname = NULL;
            }
            $stmt->close();
        }
        $conn->close();
        return $pname;
    }
    
    function sanitize_input($data) 
    {   
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>