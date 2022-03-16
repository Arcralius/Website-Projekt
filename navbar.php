<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container px-4 px-lg-5">
    <a class="navbar-brand" href="#!">PetShop2.0</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="main.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#!">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="#!">Promotions</a></li>
      </ul>
      <div class="d-flex">
        <form class="d-flex">
          <button class="btn btn-outline-dark" type="submit" id="cart">
            <i class="bi-cart-fill me-1"></i>
            Cart
            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
          </button>
        </form>
        <form action="signin.php">
          <button class="btn btn-outline-dark" type="submit" id="signin">
            Sign-In
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>