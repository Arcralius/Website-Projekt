<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Add Orders</title>
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
            <h1>Add Orders</h1>
            <form action="adminorders_add_p.php" method="post">
                <div class="form-group">
                    <label for="pid">Product ID:</label>
                    <input class="form-control" type="number" step=1 id="pid" required maxlength="20" name="pid" placeholder="Enter product id">
                </div>
                <div class="form-group">
                    <label for="uid">User ID:</label>
                    <input class="form-control" type="number" step=1 id="uid" required maxlength="20" name="uid" placeholder="Enter user id">
                </div>
                <div class="form-group">
                    <label for="s_date">Shipment Date:</label>
                    <input class="form-control" type="date" id="s_date" required name="s_date" placeholder="Enter shipment date">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="btnSubmit">Submit</button>
                </div>
                <div>
                    <p id="errormsg">
                    </p>
                </div>
            </form>
        </main>
        <?php include 'footer.php'; ?>
        <script>
            var errormsg = getCookie("errorMsg");
            if (errormsg == null) {
                errormsg = " ";
            }
            document.getElementById('errormsg').innerHTML += errormsg;
        </script>
    </body>
</html>