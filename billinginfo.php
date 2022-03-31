<!DOCTYPE HTML>
<html lang="en">
<main>

    <head>

        <?php
        include 'header.php';
        ?>
    </head>

    <body>

        <?php
        include 'navbar.php';

        if (!isset($_SESSION['username'])) {
            header("Location: /Website-Projekt/signin.php");
        } else {
            $username = $_SESSION['username'];
        }

        ?>

        <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->
            <?php include "accountnav.php" ?>

            <hr class="mt-0 mb-4">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">
                    <h1>Billing Information</h1>
                </div>
                <div class="card-body">
                    <div class="container bootstrap snippets bootdey">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-box no-header clearfix">
                                    <div class="main-box-body clearfix">
                                        <div class="table-responsive">
                                            <table class="table user-list">
                                                <thead>
                                                    <tr>
                                                        <td><span>Card Number</span></td>
                                                        <td><span>Expires Date</span></td>
                                                        <td><span>Action</span></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    takeinfo();
                                                    ?>
                                                </tbody>
                                            </table>
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcard">
                                                    Add card
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Update Card -->
            <div class="modal fade" title="updatecard" id="updatecard" tabindex="-1" aria-labelledby="updatecard" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title" id="update_card">Update Card</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="updatebillingprocess.php" method="post" class="update-form" onsubmit="addDashes(document.getElementById('updateExpiration'))">
                                <!-- Form Group (Full Name)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputFullName">Full Name</label>
                                    <?php
                                    echo '<input class="form-control" id="updateFullName" type="text" required name="fullname" placeholder="' . $fullName . '" value="' . $fullName . '"> ';
                                    ?>
                                </div>
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Card Number)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputCardNo">Card Number</label>
                                        <?php
                                        echo '<input class="form-control" id="updateCardNo" onkeypress="addSpaces(this)" type="text" maxlength="19" required name="cardno" placeholder="' . $cardNo . '" value="' . $cardNo . '"> ';
                                        ?>

                                    </div>
                                    <!-- Form Group (CVV)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputCVC">CVV</label>
                                        <?php
                                        echo '<input class="form-control" id="updateCVV" type="text" maxlength="4" required name="cvv" placeholder="' . $cvv . '" value="' . $cvv . '"> ';
                                        ?>
                                    </div>
                                </div>
                                <!-- Form Group (Expiration)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputExpiration">Expiration (MM-YY)</label>

                                    <?php
                                    echo '<input class="form-control" id="updateExpiration" onkeypress="addDashes(this)" type="text" maxlength="5" required name="expiration" placeholder="' . $expiration . '" value="' . $expiration . '"> ';
                                    ?>
                                </div>
                                <!-- Form Group (Address)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputExpiration">Address</label>

                                    <?php
                                    echo '<input class="form-control" id="updateAddress" type="text" required name="address" placeholder="' . $address . '" value="' . $address . '"> ';
                                    ?>
                                </div>

                                <!-- Payment ID (hidden) -->
                                <?php
                                echo '<input type="hidden" id="paymentid" name="paymentid" value="">';
                                ?>

                                <!-- Save changes button-->

                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Save Changes</button>


                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Card -->
            <div class="modal fade" id="deletecard" title="deletecard" tabindex="-1" aria-labelledby="billing" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title" id="deletecard">Confirm</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="deletebillingprocess.php" method="post">
                                <p id="errorsign">Are you sure you want to remove this card from your account ?</p>
                                <div class="modal-footer">
                                    <!-- Payment ID (hidden) -->
                                    <?php
                                    echo '<input type="hidden" id="deletepaymentid" name="paymentid" value="">';
                                    ?>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Card -->
            <div class="modal fade" title="addcard" id="addcard" tabindex="-1" aria-labelledby="addcard" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title" id="exampleModalLabel">Add Card</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="addbillingprocess.php" method="post" class="addcard-form" onsubmit="addDashes(document.getElementById('inputExpiration'))">
                                <!-- Form Group (Full Name)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputFullName">Full Name</label>
                                    <?php
                                    echo '<input class="form-control" id="inputFullName" type="text" required name="fullname" placeholder="Full Name"> ';
                                    ?>
                                </div>
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (Card Number)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputCardNo">Card Number</label>
                                        <?php
                                        echo '<input class="form-control" id="inputCardNo" onkeypress="addSpaces(this)" type="text" maxlength="19" required name="cardno" placeholder="Card Number"> ';
                                        ?>

                                    </div>
                                    <!-- Form Group (CVV)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputCVC">CVV</label>
                                        <?php
                                        echo '<input class="form-control" id="inputCVV" type="text" maxlength="4" required name="cvv" placeholder="CVV"> ';
                                        ?>
                                    </div>
                                </div>
                                <!-- Form Group (Expiration)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputExpiration">Expiration (MM-YY)</label>

                                    <?php
                                    echo '<input class="form-control" id="inputExpiration" onkeypress="addDashes(this)" type="text" maxlength="5" required name="expiration" placeholder="Expiry Date"> ';
                                    ?>
                                </div>
                                <!-- Form Group (Address)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputExpiration">Address</label>

                                    <?php
                                    echo '<input class="form-control" id="inputAddress" type="text" required name="address" placeholder="Address"> ';
                                    ?>
                                </div>

                                <!-- Save changes button-->

                                <button type="submit" class="form-control btn btn-primary rounded submit px-3" >Save Changes</button>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <p id="succmessage">
                </p>
                <p id="errormsg">
                </p>
            </div>



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

            <?php function takeinfo()
            {
                global $errorMsg, $success, $paymentID, $fullName, $cardNo, $expiration, $address, $cvv;
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
                    $stmt = $conn->prepare("SELECT payment_id, user_id, name, card_number, CVC, date_format(expiration, '%m-%y') AS expiration, address FROM payment_details WHERE user_id=?");
                    // Bind & execute the query statement:         
                    $stmt->bind_param("i", $_SESSION['id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            $paymentID = $row["payment_id"];
                            $fullName = $row["name"];
                            $cardNo = $row["card_number"];
                            $cvv = $row["CVC"];
                            $expiration = $row["expiration"];
                            $address = $row["address"];

                            echo '<tr>';
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
                            echo '<td class = "align-middle">';
                            echo '<button type = "button" onclick = "passpaymentID(this)" class = "btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatecard" value="' . $paymentID . '">Update</button>';
                            echo '<button type = "button" onclick = "passpaymentID(this)" class = "btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletecard" value="' . $paymentID . '">Delete</button>';
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
    </body>
</main>