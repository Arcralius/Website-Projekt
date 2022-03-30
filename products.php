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
    <!-- Header-->
    <header class="bg-dark py-5">
      <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
          <h1 class="display-4 fw-bolder">All products</h1>
        </div>
      </div>
    </header>
    <!-- Section-->
    <div class="container pt-5">
      <div class="row">
        <div class="col-md-8 order-md-2 col-lg-9">
          <div class="container-fluid">
            <div class="row">
              <?php
              if (isset($_POST['sort'])) {
                if (!empty($_POST['categories'])) {
                  $categories = $_POST['categories'];
                  sortProducts($categories);
                } else {
                  printproducts();
                }
              } else {
                printproducts();
              }
              ?>
            </div>
            <div class="row sorting mb-5 mt-5">
              <div class="col-12">
                <a href=# class="btn btn-light">
                  <i class="bi bi-arrow-up"></i> Back to top</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 order-md-1 col-lg-3 sidebar-filter" style="background-color: #FFFFFF;">
          <form action="" method="post">
            <p class="mt-0 mb-5">Showing <span class="text-primary"><?= $number_of_products ?></span> Products</p>
            <p class="text-uppercase font-weight-bold mb-3">Categories</p>
            <?php 
            printcatagories();
            ?>
            <!-- <div class="divider mt-5 mb-5 border-bottom border-secondary"></div>
            <p class="text-uppercase mt-5 mb-3 font-weight-bold">Price</p>
            <div class="price-filter-control">
              <label for="price-min-control">min price</label>
              <input type="number" class="form-control w-50 pull-left mb-2" value="50" id="price-min-control">
              <label for="price-max-control">max price</label>
              <input type="number" class="form-control w-50 pull-right" value="150" id="price-max-control">
            </div>
            <input id="ex2" type="text" class="slider " value="50,150" data-slider-min="10" data-slider-max="200" data-slider-step="5" data-slider-value="[50,150]" data-value="50,150" style="display: none;"> -->
            <div class="divider mt-5 mb-5 border-bottom border-secondary"></div>
            <input type="submit" name="sort" class="btn btn-lg btn-block btn-primary mt-5" style="margin-bottom: 10%;" value="Update Results" />
        </div>
        </form>
      </div>
    </div>

    <?php



    function printproducts()
    {
      require("conn.php");

      $sql = "SELECT * FROM `products`; ";
      $result = $conn->query($sql);

      global $productName, $productPrice, $productImage, $quantity, $description, $number_of_products;

      $number_of_products = $result->num_rows;

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

          $productID = $row['product_id'];
          $productImage = $row['product_image'];
          $productName = $row['product_name'];
          $productPrice = $row['product_price'];
          $quantity = $row['product_quantity'];
          $description = $row['product_desc'];


          echo '<div class="col-6 col-md-6 col-lg-4 mb-3">';
          echo '<div class="card h-100">';
          echo '<img class="card-img-top" src="' . $productImage . '" alt="' . $description . '" />';
          echo '<div class="card-body p-4">';
          echo '<div class="text-center">';
          echo '<p class="fw-bolder">' . $productName . '</p>';
          echo '<span class="text-muted text-decoration-line-through">$' . $productPrice . '</span>';
          echo '</div>';
          echo '</div>';
          echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
          echo '<form action="product.php" method="post">';
          echo '<input type="hidden" name="productID" value="' . $productID . '">';
          //echo '<div class="text-center"><a class="form-control btn btn-outline-dark rounded submit px-3" href="product.php?id=' . $productID . '">View options</a></div>';
          echo '<button type="submit" class="form-control btn btn-outline-dark rounded submit px-3">View Details</button>';
          echo '</form>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        $conn->close();
      } else {
        echo "0 results";
      }
    }

    function sortProducts($productCat)
    {
      require("conn.php");

      $count = count($productCat);
      $placeholders = implode(',', array_fill(0, $count, '?'));
      $bindStr = str_repeat('s', $count);

      $sql = "SELECT * FROM products where product_category IN ($placeholders); ";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param($bindStr, ...$productCat);
      $stmt->execute();
      $result = $stmt->get_result();

      global $number_of_products;
      $number_of_products = $result->num_rows;

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

          $productID = $row['product_id'];
          $productImage = $row['product_image'];
          $productName = $row['product_name'];
          $productPrice = $row['product_price'];
          $quantity = $row['product_quantity'];
          $description = $row['product_desc'];

          echo '<div class="col-6 col-md-6 col-lg-4 mb-3">';
          echo '<div class="card h-100">';
          echo '<img class="card-img-top" src="' . $productImage . '" alt="' . $description . '" />';
          echo '<div class="card-body p-4">';
          echo '<div class="text-center">';
          echo '<h5 class="fw-bolder">' . $productName . '</h5>';
          echo '<span class="text-muted text-decoration-line-through">$' . $productPrice . '</span>';
          echo '</div>';
          echo '</div>';
          echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
          echo '<form action="product.php" method="post">';
          echo '<input type="hidden" id="productID" name="productID" value="' . $productID . '">';
          //echo '<div class="text-center"><a class="form-control btn btn-outline-dark rounded submit px-3" href="product.php?id=' . $productID . '">View options</a></div>';
          echo '<button type="submit" class="form-control btn btn-outline-dark rounded submit px-3">View Details</button>';
          echo '</form>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        $stmt->close();
        $conn->close();
      } else {
        echo "0 results";
      }
    }

    function printcatagories(){
      require("conn.php");

      $sql = "SELECT DISTINCT product_category FROM `products`;";
      $result = $conn->query($sql);

      global $product_catagory;


      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

          $product_catagory = $row['product_category'];


          echo '<div class="mt-2 mb-2 pl-2">';
          echo '<div class="custom-control custom-checkbox">';
          echo '<input type="checkbox" class="custom-control-input" name="categories[]" value="'.$product_catagory .'" id="'. $product_catagory .'">';
          echo '<label class="custom-control-label" for="'.$product_catagory .'">'.$product_catagory .'</label>';
          echo '</div>';
          echo '</div>';
        }
        $conn->close();
      } else {
        echo "No catagories";
      }
    }
    ?>



  </body>

</html>
</main>