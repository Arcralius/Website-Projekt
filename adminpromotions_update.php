<!DOCTYPE HTML>

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
    function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        if (isset($_POST['update'])) {
            $promotion_id = sanitize_input((int)$_GET['promotion_id']);
            $prod_id = sanitize_input((int)$_POST['prod_id']);
            $discount = sanitize_input((int)$_POST['discount']);



            $stmt = $conn->prepare("UPDATE `promotions` SET `prod_id`=?,`discount`=? WHERE `promotion_id`=?");
            // Bind & execute the query statement:
            $stmt->bind_param("iii", $prod_id, $discount, $promotion_id);
            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }
            else{
                echo "<h3>Promotion entry updated!</h3>";
                echo "<br><button class=\"btn btn-success\" type=\"submit\" onclick=\"window.location.href='adminpromotions.php'\">Back to promotion table</button>";
            }
            $stmt->close();
        } 

    if (isset($_GET['promotion_id'])) {
        $promotion_id = $_GET['promotion_id']; 
        $sql = "SELECT * FROM `promotions` WHERE `promotion_id`='$promotion_id'";
        $result = $conn->query($sql); 
        if ($result->num_rows > 0) {        
            while ($row = $result->fetch_assoc()) {
                $promotion_id = $row['promotion_id'];
                $prod_id = $row['prod_id'];
                $discount = $row['discount'];
            } 
            
        ?>
        
            <h1>Update Promotion</h1>

            <form action="" method="post">
              <fieldset>
                <div class="form-group">
                <label for="promotion_id">Promotion ID:</label>
                <input class="form-control" type="number" name="promotion_id" value="<?php echo $promotion_id; ?>" disabled>
                </div>
                <div class="form-group">
                <label for="prod_id">Product ID:</label>
                <input class="form-control" type="number" step=1 name="prod_id" required maxlength="20" value="<?php echo $prod_id; ?>">
                </div>
                <div class="form-group">
                <label for="discount">Discount:</label>
                <input class="form-control" type="number" step=1 name="discount" required maxlength="11" value="<?php echo $discount; ?>">
                </div>
                <div class="form-group">
                <button class="btn btn-primary" type="submit" value="update" name="update">Submit</button>
                </div>
              </fieldset>
            </form> 
            </body>
            </html>
            
        <?php
        } else{ 
            header('Location: adminpromotions.php');
        } 
    }

?> 
</main>


</body>