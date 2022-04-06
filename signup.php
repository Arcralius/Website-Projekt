<!DOCTYPE HTML>
<html lang="en">



<head>
    <?php
    include 'header.php';
    ?>

</head>

<body>
<main>
    <?php
    include 'navbar.php';
    ?>
    <div class="card mb-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h1 class="mb-4">Sign Up</h1>
                        </div>
                    </div>
                    <form action="signupprocess.php" method="post" class="signup-form">
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" required type="username" id="username" name="username">
                            <label class="form-control-placeholder" for="username">Username*</label>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" required type="email" id="email" name="email">
                            <label class="form-control-placeholder" for="email">Email*</label>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" type="fname" id="fname" name="fname">
                            <label class="form-control-placeholder" for="fname">First name</label>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" required type="lname" id="lname" name="lname">
                            <label class="form-control-placeholder" for="lname">Last name*</label>
                        </div>
                        <div class="form-group">
                            <input id="password-field" type="password" class="form-control" required type="password" id="password" name="password">
                            <label class="form-control-placeholder" for="password-field">Password*</label>
                        </div>
                        <div class="form-group">
                            <input id="cfm-password-field" type="password" class="form-control" required type="cfm_password" id="cfm_password" name="cfm_password">
                            <label class="form-control-placeholder" for="cfm-password-field">Confirm Password*</label>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign Up</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <p class="h6" id="compulse">* are compulsory fields</p>
                        </div>
                        <div>
                            <p id="errormsg">
                            </p>
                        </div>
                        <script>
                            var errormsg = getCookie("errorMsg");
                            if (errormsg == null) {
                                errormsg = " ";
                            }
                            document.getElementById('errormsg').innerHTML += errormsg;


                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>



</main>
</html>