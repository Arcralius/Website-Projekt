<!DOCTYPE HTML>
<html>

<head>
    <title>test</title>
    <?php
    include 'header.php';
    ?>

</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <div class="container" id="main">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h3 class="mb-4">Sign In</h3>
                        </div>
                    </div>
                    <form action="signinprocess.php" method="post" class="signin-form">
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" required type="username" id="username" name="username">
                            <label class="form-control-placeholder" for="username">Username</label>
                        </div>
                        <div class="form-group">
                            <input id="password-field" type="password" class="form-control" required type="password" id="password" name="password">
                            <label class="form-control-placeholder" for="password">Password</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50 text-left">
                                <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="w-50 text-md-right">
                                <a href="#">Forgot Password</a>
                            </div>
                        </div>
                    </form>
                    <p class="text-center">Not a member? <a data-toggle="tab" href="signup.php">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>