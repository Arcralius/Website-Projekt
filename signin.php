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
    ?>

    <div class="card mb-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h1 class="mb-4">Sign In</h1>
                        </div>
                    </div>
                    <form action="signinprocess.php" method="post" class="signin-form">
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" required type="username" id="username" name="username">
                            <label class="form-control-placeholder" for="username">Username</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" required type="password" id="password" name="password">
                            <label class="form-control-placeholder" for="password">Password</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                        </div>
                    </form>
                    <p class="text-center h6">Not a member? <a data-toggle="tab" href="signup.php"><em>Sign Up</em></a></p>
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