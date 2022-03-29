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
    takeinfo();
    ?>

    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <ul class="list-group list-group-horizontal">
                <li class="list-group-item"><a class="nav-link active ms-0" href="/Website-Projekt/account.php">Profile</a></li>
                <li class="list-group-item"><a class="nav-link" href="/Website-Projekt/billinginfo.php">Billing</a></li>
                <li class="list-group-item"><a class="nav-link" href="/Website-Projekt/2fa.php">Security</a></li>
            </ul>

        <hr class="mt-0 mb-4">
        <!-- Account details card-->
        <div class="card mb-4">
            <div class="card-header"><h1>Billing Information</h1></div>
            <div class="card-body">
                <form action="updatebillingprocess.php" method="post" class="update-form">
                    <!-- Form Group (Full Name)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="inputFullName">Full Name</label>
                        <?php
                        echo '<input class="form-control" id="inputFullName" type="text" required name="fullname" placeholder="' . $fullName . '" value="' . $fullName . '"> ';
                        ?>
                    </div>
                    <div class="row gx-3 mb-3">
                        <!-- Form Group (Card Number)-->
                        <div class="col-md-6">
                            <label class="small mb-1" for="inputCardNo">Card Number</label>
                            <?php
                            echo '<input class="form-control" id="inputCardNo" onkeypress="addSpaces(this)" type="text" maxlength="19" required name="cardno" placeholder="' . $cardNo . '" value="' . $cardNo . '"> ';
                            ?>

                        </div>
                        <!-- Form Group (CVV)-->
                        <div class="col-md-6">
                            <label class="small mb-1" for="inputCVC">CVV</label>
                            <?php
                            echo '<input class="form-control" id="inputCVV" type="text" maxlength="4" required name="cvv" placeholder="' . $cvv . '" value="' . $cvv . '"> ';
                            ?>
                        </div>
                    </div>
                    <!-- Form Group (Expiration)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="inputExpiration">Expiration (MM-YY)</label>

                        <?php
                        echo '<input class="form-control" id="inputExpiration" onkeypress="addDashes(this)" type="text" maxlength="5" required name="expiration" placeholder="'. $expiration . '" value="' . $expiration . '"> ';
                        ?>
                    </div>
                    <!-- Form Group (Address)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="inputExpiration">Address</label>

                        <?php
                        echo '<input class="form-control" id="inputExpiration" type="text" required name="address" placeholder="' . $address . '" value="' . $address . '"> ';
                        ?>
                    </div>
                    
                    <!-- Save changes button-->
                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Save Changes</button>
                </form>
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
            global $errorMsg, $success, $fullName, $cardNo, $cvv, $expiration, $address;
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
            } 
            else {
                // Prepare the statement:         
                $stmt = $conn->prepare("SELECT * FROM payment_details WHERE user_id=?");
                // Bind & execute the query statement:         
                $stmt->bind_param("i", $_SESSION['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                                 
                    $row = $result->fetch_assoc();
                    $fullName = $row["name"];
                    $cardNo = $row["card_number"];
                    $cvv = $row["cvc"];
                    $expiration = $row["expiration"];
                    $address = $row["address"];
                }

                $stmt->close();
            }
            $conn->close();
        }
        ?>
</body>
</main>

