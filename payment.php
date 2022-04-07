<!DOCTYPE HTML>
<html lang="en">
    <head>
        <?php
        include 'header.php';
        ?>
    </head>
    <body>
        <?php include 'navbar.php'; ?>
        <main>
            <div class="album py-3 bg-white">
                <div class="container" id="payment">
                    <h1 class='center text-center'>Checkout</h1>
                    <?php
                        if (isset($_SESSION["role"])) {
                            echo '<div class="paymentsummary"></div>';
                        } else
                            echo "<div class='center text-center'><h2>You must be signed in to access your cart.</h2></div>";
                        if  (isset($_SESSION["role"]) && !empty($_SESSION["cart"])) {
                            
                            takeinfo();
                        }
                    ?>
                    <div class = "center text-center">
                        <p id="errormsg"></p>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php';?>
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
    function takeinfo()
    {
        $userid = $paymentID = $cardNo = $expiration = 0;
        $errorMsg = $fullName = $address = "";
        $success = true;
        $userid = $_SESSION['id'];
        $config = parse_ini_file("../../private/db-config.ini");
        $conn = new mysqli(
            $config["servername"],
            $config["username"],
            $config["password"],
            $config["dbname"]
        );
        // Check connection
        if ($conn->connect_error) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        } else {
            // Prepare the statement:         
            $stmt = $conn->prepare("SELECT * FROM payment_details WHERE user_id=?");
            // Bind & execute the query statement:      
            $userid = mysqli_real_escape_string($conn, $userid);
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                echo '<div class="table-responsive">';
                echo '<table class="table user-list">';
                echo '<thead>';
                echo '<tr>';
                echo '<th class="align-middle text-center"><span>Card Holder</span></th>';
                echo '<th class="align-middle text-center"><span>Card Number</span></th>';
                echo '<th class="align-middle text-center"><span>Expiration Date</span></th>';
                echo '<th class="align-middle text-center"><span>Delivery Address</span></th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>'; 
                while ($row = $result->fetch_assoc()) {
                    $paymentID = $row["payment_id"];
                    $fullName = $row["name"];
                    $cardNo = $row["card_number"];
                    $expiration = $row["expiration"];
                    $address = $row["address"];

                    echo '<tr>';
                    echo '<td class="align-middle text-center">';
                    echo '<span class = "label label-default">' . htmlspecialchars($fullName) . '</span>';
                    echo '</td>';
                    if ($cardNo[0] == 5) {
                        echo '<td class="align-middle text-center">';
                        echo '<img src = "https://cdn.mos.cms.futurecdn.net/H3evjLMg9aGDBbaEw9EF2m-80-80.jpg" alt = "mastercard-logo">';
                        echo '<span class = "label label-default">' . substr($cardNo, 0, 4) . ' **** **** ****</span>';
                        echo '</td>';
                    }
                    else if ($cardNo[0] == 4 ) {
                        echo '<td class="align-middle text-center">';
                        echo '<img src = "https://laz-img-cdn.alicdn.com/tfs/TB1RI0cbLDH8KJjy1XcXXcpdXXa-80-80.png" alt = "visa-logo">';
                        echo '<span class = "label label-default">' . substr($cardNo, 0, 4) . ' **** **** ****</span>';
                        echo '</td>';
                    }
                    else{
                        echo '<td class="align-middle text-center">';
                        echo '<span class = "label label-default">' . substr($cardNo, 0, 4) . ' **** **** ****</span>';
                        echo '</td>';
                    }
                    echo '<td class="align-middle text-center">';
                    echo '<span class = "label label-default">Expires on ' . $expiration . '</span>';
                    echo '</td>';
                    echo '<td class="align-middle text-center">';
                    echo '<span class = "label label-default">' . htmlspecialchars($address) . '</span>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '<div class="center text-center">';
                

                echo '<form action="paymentProcess.php" method="post">';
                echo '<button class="btn btn-success">Confirm Transaction</button>';
                echo '<input type="hidden" name="qty_order" value="'.$_POST["qty_order"].'">';
                echo '</form>';
                echo '</div>';
            } else {
                echo '<div class="center text-center">';
                echo "No available cards to display.";
                echo '<form action="billinginfo.php">';
                echo '<button class="btn btn-success">Add a Card</button>';
                echo '</form>';
                echo '</div>';
            }
            $stmt->close();
        }
        $conn->close();
    }
?>
