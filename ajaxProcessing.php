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
     
    function addToCart() {
        $config = parse_ini_file("../../private/db-config.ini");
        $existing = false;
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
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } else {
                    $stmt = $conn->prepare("SELECT * FROM `products` WHERE product_id=?;");
                    $stmt->bind_param("d", $_POST['addtocart']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        array_push($_SESSION["cart"], array($row['product_id'],
                            $row['product_name'], $row['product_desc'], $row['product_thumbnail'],
                            $row['product_price'], 1, $row['product_quantity']));
                    }
                echo count($_SESSION["cart"]);
                }
            }
        } else {
            $conn = new mysqli($config["servername"], $config["username"],
                    $config["password"], $config["dbname"]);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } else {
                    $stmt = $conn->prepare("SELECT * FROM `products` WHERE product_id=?;");
                    $stmt->bind_param("d", $_POST['addtocart']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $_SESSION["cart"] = array(array($row['product_id'], $row['product_name'], $row['product_desc'],
                            $row['product_thumbnail'],$row['product_price'], 1, $row['product_quantity']));
                    }
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
            echo '<table class="cart">';
            foreach($_SESSION["cart"] as $prod) {
                echo '<tr><td>';
                echo '<a href="product.php?id=' . $prod[0] . '">';
                echo '<img class="card-img-top" src=' . $prod[3] . ' alt="Card image cap">';
                echo '</a>';
                echo '<td>' . $prod[1] . '</td>';
                echo '<td>' . $prod[2] . '</td>';
                echo '<td>$' . $prod[4] * $prod[5] . '</td>';
                echo '<td>Qty: ';
                echo '<select name="prod_qty">';
                for ($i=1; $i<=$prod[6];$i++) {
                    if ($i == $prod[5]) {
                        echo '<option selected value="' . $prod[0] . ':' . $i . '">' . $i . '</option>';
                    } else {
                        echo '<option value="' . $prod[0] . ':' . $i . '">' . $i . '</option>';
                    }
                }
                echo '</select></td>';
                echo '<td>Stock: ' . $prod[6] . '</td>';
                echo '<td><button name="removefromcart" value="' . $prod[0] .'"class="btn btn-danger">Remove from Cart</button></td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<div class="center">';
            echo '<form action="payment.php">';
            echo '<button class="btn btn-success">Proceed to payment</button>';
            echo '</form';
            echo '</div>';
        } else {
            echo "Your cart is currently empty.";
        }
    }
    
    function setProdQty() {
        if (!empty($_SESSION["cart"])) {
            $pid = intval(explode(":",$_POST['setprodqty'])[0]);
            $qty = intval(explode(":",$_POST['setprodqty'])[1]);
            foreach($_SESSION["cart"] as $index => $prod) {
                if ($prod[0] == $pid) {
                    if ($qty <= $prod[6])
                        $_SESSION["cart"][$index][5] = $qty;
                }
            }
        }
    }
?>
