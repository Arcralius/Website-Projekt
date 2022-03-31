<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container px-4 px-lg-5">
    <a class="navbar-brand" href="main.php">PetShop2.0</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item"><a class="nav-link" aria-current="page" href="main.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="abtme.php">About Us</a></li>

          <?php
          session_start();
          
          if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 1800)) {
            session_unset();
            session_destroy();
          }
          $_SESSION['start'] = time();
          $cart;
          if (!empty($_SESSION["cart"]))
            $cart = count($_SESSION["cart"]);
          else
            $cart = 0;
          if (!isset($_SESSION["role"])) {
            echo '</ul>';
            echo '<div class="p-1">';
            echo '<form action="signin.php">';
            echo '<button class="btn btn-outline-dark" type="submit" id="signin" style="width:100%;">';
            echo 'Sign-In';
            echo '</button>';
            echo '</form>';
            echo '</div>';
          } else {
            echo '<li class="nav-item"><a class="nav-link" href="account.php">Account</a></li>';
            
            if ($_SESSION["role"] == "A") {
              echo '<li class="nav-item"><a class="nav-link" href="adminhome.php">Admin</a></li>';
            }
            echo '</ul>';
            echo '<form action="checkout.php">';
            echo '<div class="p-1">';
            echo '<button class="btn btn-outline-dark" type="submit" id="cart">';
            echo '<i class="bi-cart-fill me-1"></i>';
            echo 'Cart';
            echo '<span class="badge bg-dark text-white ms-1 rounded-pill cartitems">' . $cart . '</span>';
            echo '</button>';
            echo '</div>';
            echo '</form>';
            echo '<div class="p-1">';
            echo '<form action="signoutprocess.php">';
            echo '<button class="btn btn-outline-dark" type="submit" id="signin" style="width:100%;">';
            echo 'Sign-Out';
            echo '</button>';
            echo '</form>';
            echo '</div>';
          }
          ?>
    </div>
  </div>
</nav>