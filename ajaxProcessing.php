<?php
    session_start();
    if (isset($_POST['addtocart'])) {
        addToCart();
    } else if (isset($_POST['removefromcart'])) {
        removeFromCart();
    } else if (isset($_POST['getcart']))
        getCart();
     else if (isset($_POST['setprodqty']))
        setProdQty();
     else if (isset($_POST['getpayment']))
        getPayment();
    function addToCart() {
        $config = parse_ini_file("../../private/db-config.ini");
        $existing = false;
        $pid = $discount = 0;
        if (!empty($_SESSION["cart"])) {
            foreach($_SESSION["cart"] as $prod) {
                if ($_POST['addtocart'] == $prod[0]) {
                    echo "Already in cart";
                    $existing = true;
                    break;
                }
            }
            if (!$existing) {
                $conn = new mysqli($config["servername"], $config["username"],
                    $config["password"], $config["dbname"]);
                $pid = mysqli_real_escape_string($conn, $_POST["addtocart"]);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } else {
                    $stmt = $conn->prepare("SELECT * FROM `promotions` WHERE prod_id=?;");
                    $stmt->bind_param("d", $pid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['start_date']  <= date("Y-m-d") && $row['end_date'] >= date("Y-m-d")) {
                                $discount = $row['discount'];
                                break;
                            }
                        }
                    }
                    
                    $stmt = $conn->prepare("SELECT * FROM `products` WHERE product_id=?;");
                    $stmt->bind_param("d", $pid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        array_push($_SESSION["cart"], array($row['product_id'],
                            $row['product_name'], $row['product_desc'], $row['product_thumbnail'],
                            $row['product_price'], $discount, 1, $row['product_quantity']));
                    }
                    $stmt->close();
                    $conn->close();
                echo count($_SESSION["cart"]);
                }
            }
        } else {
            $conn = new mysqli($config["servername"], $config["username"],
                $config["password"], $config["dbname"]);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                $stmt = $conn->prepare("SELECT * FROM `promotions` WHERE prod_id=?;");
                $pid = mysqli_real_escape_string($conn, $_POST["addtocart"]);
                $stmt->bind_param("d", $pid);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['start_date']  <= date("Y-m-d") && $row['end_date'] >= date("Y-m-d")) {
                            $discount = $row['discount'];
                            break;
                        }
                    }
                }

                $stmt = $conn->prepare("SELECT * FROM `products` WHERE product_id=?;");
                $stmt->bind_param("d", $pid);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION["cart"] = array(array($row['product_id'], $row['product_name'], $row['product_desc'],
                        $row['product_thumbnail'],$row['product_price'], $discount, 1, $row['product_quantity']));
                }
                $stmt->close();
                $conn->close();
                echo count($_SESSION["cart"]);
            }
        }
    }
    
    function removeFromCart() {
        if (!empty($_SESSION["cart"])) {
            foreach($_SESSION["cart"] as $index => $prod) {
                if ($_POST['removefromcart'] == $prod[0]) {
                    unset($_SESSION["cart"][$index]);
                    $_SESSION["cart"] = array_values($_SESSION["cart"]);
                    echo count($_SESSION["cart"]);
                    break;
                }
            }
        }
    }
    
    function getCart() {
        if (!empty($_SESSION["cart"])) {
            $totalCost = $discountCost = 0;
            echo '<h2>Cart</h2>';
            echo '<table class="table cart">';
            echo '<thead><tr>';
            echo '<th class="align-middle text-center">Thumbnail</th>';
            echo '<th class="align-middle text-center">Product</th>';
            echo '<th class="align-middle text-center">Description</th>';
            echo '<th class="align-middle text-center">Price</th>';
            echo '<th class="align-middle text-center">Quantity</th>';
            echo '<th class="align-middle text-center">Stock</th>';
            echo '<th></th></tr></thead>';
            foreach($_SESSION["cart"] as $prod) {
                $discountCost = $prod[4] * (100 - $prod[5])/100;
                $totalCost += $discountCost * $prod[6];
                
                echo '<tr><td class="align-middle text-center">';
                echo '<a href="product.php?id=' . $prod[0] . '">';
                echo '<img class="img-thumbnail cart" src="' . $prod[3] . '" alt="Card image cap">';
                echo '</a>';
                echo '<td class="align-middle text-center">' . $prod[1] . '</td>';
                echo '<td class="align-middle text-center">' . $prod[2] . '</td>';
                if ($prod[5] != 0) 
                    echo '<td class="align-middle text-center"><s>$' . $prod[4] * $prod[6] . '</s> $' . $discountCost * $prod[6] . '</td>';
                else
                    echo '<td class="align-middle text-center">$' . $discountCost * $prod[6] . '</td>';
                echo '<td class="align-middle text-center">';
                echo '<select aria-label="qty" name="prod_qty">';
                for ($i=1; $i<=$prod[7];$i++) {
                    if ($i == $prod[6]) {
                        echo '<option selected value="' . $prod[0] . ':' . $i . '">' . $i . '</option>';
                    } else {
                        echo '<option value="' . $prod[0] . ':' . $i . '">' . $i . '</option>';
                    }
                }
                echo '</select></td>';
                echo '<td class="align-middle text-center">' . $prod[7] . '</td>';
                echo '<td class="align-middle text-center"><button name="removefromcart" value="' . $prod[0] .'"class="btn btn-danger">Remove from Cart</button></td>';
                echo '</tr>';
            }
            echo '<tr><th></th><th></th><th></th><th></th><th></th><th></th><th class="align-middle text-center">Total</th></tr>';
            echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td class="align-middle text-center">$' . $totalCost . '</td></tr>';
            echo '</table>';
            echo '<form action="payment.php" method="post">';
            echo '<div class="center text-center">';
            echo '<input type="hidden" name="qty_order" value="'.$prod[6].'">';
            echo '<button class="btn btn-success">Proceed to payment</button>';
            echo '</div>';
            echo '</form>';
        } else {
            echo "<div class='center text-center'><h2>Your cart is currently empty.</h2></div>";
        }
    }
    
    function setProdQty() {
        if (!empty($_SESSION["cart"])) {
            $pid = intval(explode(":",$_POST['setprodqty'])[0]);
            $qty = intval(explode(":",$_POST['setprodqty'])[1]);
            foreach($_SESSION["cart"] as $index => $prod) {
                if ($prod[0] == $pid) {
                    if ($qty <= $prod[7])
                        $_SESSION["cart"][$index][6] = $qty;
                }
            }
        }
    }
    
    function getPayment() {
        if (!empty($_SESSION["cart"])) {
            $totalCost = $discountCost = 0;
            echo '<h2>Payment Summary</h2>';
            echo '<div class="table-responsive">';
            echo '<table class="table user-list">';
            echo '<thead><tr>';
            echo '<th class="align-middle text-center">Product</th>';
            echo '<th class="align-middle text-center">Quantity</th>';
            echo '<th class="align-middle text-center">Subtotal</th>';
            echo '</tr></thead>';
            foreach($_SESSION["cart"] as $prod) {
                $discountCost = $prod[4] * (100 - $prod[5])/100;
                $totalCost += $discountCost * $prod[6];
                
                echo '<tr>';
                echo '<td class="align-middle text-center">' . $prod[1] . '</td>';
                echo '<td class="align-middle text-center">' . $prod[6] . '</td>';
                if ($prod[5] != 0) 
                    echo '<td class="align-middle text-center"><s>$' . $prod[4] * $prod[6] . '</s> $' . $discountCost * $prod[6] . '</td>';
                else
                    echo '<td class="align-middle text-center">$' . $discountCost * $prod[6] . '</td>';
                echo '</tr>';
            }
            echo '<tr><th></th><th></th><th class="align-middle text-center">Total</th></tr>';
            echo '<tr><td></td><td></td><td class="align-middle text-center">$' . $totalCost . '</td></tr>';
            echo '</table>';
            echo '</div>';
        } else {
            echo "<div class='center text-center'><h2>Your cart is currently empty.</h2></div>";
        }
    }
?>
