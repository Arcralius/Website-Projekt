<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Payment</title>
        <?php
        include 'header.php';
        ?>
    </head>
    <body>
        <?php include 'navbar.php'; ?>
        <main>
            <div class="album py-3 bg-white">
                <div class="container" id="payment">
                    <section>
                        <?php
                        if (isset($_SESSION["role"])) {
                            echo '<div class="paymentsummary"></div>';
                            echo '<div class="table-responsive">';
                            echo '<table class="table user-list">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th><span>Card Holder</span></th>';
                            echo '<th><span>Card Number</span></th>';
                            echo '<th><span>Expiration Date</span></th>';
                            echo '<th><span>Delivery Address</span></th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>'; 
                            takeinfo();
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                            echo '<div class="center">';
                            echo '<form action="paymentProcess.php">';
                            echo '<button class="btn btn-success">Confirm Transaction</button>';
                            echo '</form>';
                            echo '</div>';
                        } else
                            echo "You must be signed in to access your cart.";
                        ?>
                    </section>
                    <div class = "center">
                        <p id="errormsg"></p>
                    </div>
                    <script>
                        var errormsg = getCookie("errorMsg");
                        if (errormsg == null) {
                            errormsg = " ";
                        }
                        document.getElementById('errormsg').innerHTML += errormsg;
                    </script>
                </div>
            </div>
        </main>
        <?php include 'footer.php';?>
    </body>
</html>

<?php
    function takeinfo()
    {
        global $errorMsg, $success, $paymentID, $fullName, $cardNo, $expiration, $address;
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
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    $paymentID = $row["payment_id"];
                    $fullName = $row["name"];
                    $cardNo = $row["card_number"];
                    $expiration = $row["expiration"];
                    $address = $row["address"];

                    echo '<tr>';
                    echo '<td>';
                    echo '<span class = "label label-default">' . $fullName . '</span>';
                    echo '</td>';
                    if ($cardNo[0] == 5) {
                        echo '<td>';
                        echo '<img src = "https://cdn.mos.cms.futurecdn.net/H3evjLMg9aGDBbaEw9EF2m-80-80.jpg" alt = "mastercard-logo">';
                        echo '<span class = "label label-default">' . substr($cardNo, 0, 4) . ' **** **** ****</span>';
                        echo '</td>';
                    }
                    else if ($cardNo[0] == 4 ) {
                        echo '<td>';
                        echo '<img src = "https://laz-img-cdn.alicdn.com/tfs/TB1RI0cbLDH8KJjy1XcXXcpdXXa-80-80.png" alt = "visa-logo">';
                        echo '<span class = "label label-default">' . substr($cardNo, 0, 4) . ' **** **** ****</span>';
                        echo '</td>';
                    }
                    else{
                        echo '<td>';
                        echo '<span class = "label label-default">' . substr($cardNo, 0, 4) . ' **** **** ****</span>';
                        echo '</td>';
                    }
                    echo '<td class = "align-middle">';
                    echo '<span class = "label label-default">Expires on ' . $expiration . '</span>';
                    echo '</td>';
                    echo '<td>';
                    echo '<span class = "label label-default">' . $address . '</span>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo "No available cards to display.";
            }

            $stmt->close();
        }
        $conn->close();
    }
?>
