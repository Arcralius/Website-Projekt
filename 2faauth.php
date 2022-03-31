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
        session_start();

        if (!isset($_SESSION["username"])) {
            echo '<script>';
            echo 'window.location.href = "signin.php";';
            echo '</script>';
        }

        $username = $_SESSION["username"];



        session_destroy();
        include 'navbar.php';



        ?>

        <div class="card mb-4">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h1 class="mb-4">Enter 2 FA </h1>
                            </div>
                        </div>
                        <form action="2faauthprocess.php" method="post" class="signin-form">
                            <div class="form-group mt-3">
                                <input class="form-control" required type="number" maxlength="6" id="fa" name="fa">
                                <label class="form-control-placeholder" for="fa">Please enter 2 FA</label>
                            </div>
                            <input type="hidden" name="username" value="<?php echo $username ?>">
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                            </div>
                        </form>
                        <div>
                            <p id="succmessage">
                            </p>
                            <p id="errormsg">
                            </p>
                        </div>
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
                </div>
            </div>
        </div>
    </body>
</main>

</html>