<!DOCTYPE HTML>

<head>
    <title>test</title>
    <?php
    include 'header.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
    <body>
    <?php
    include 'navbar.php';
    ?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <div class="container pt-5">
              <div class="row">
                <div class="col-md-8 order-md-2 col-lg-9">
                  <div class="container-fluid">
                    <div class="row   mb-5">
                      <div class="col-12">
                        
                        <div class="dropdown float-right">
                          <label class="mr-2">View:</label>
                          <a class="btn btn-lg btn-light dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">9 <span class="caret"></span></a>
                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" x-placement="bottom-end" style="will-change: transform; position: absolute; transform: translate3d(120px, 48px, 0px); top: 0px; left: 0px;">
                            <a class="dropdown-item" href="#">12</a>
                            <a class="dropdown-item" href="#">24</a>
                            <a class="dropdown-item" href="#">48</a>
                            <a class="dropdown-item" href="#">96</a>
                          </div>
                        </div>
                      </div>
                    </div>
                      <div class="row">
                      <?php 
                      printproducts()
                      ?>
                    </div>
                    <div class="row sorting mb-5 mt-5">
                      <div class="col-12">
                        <a class="btn btn-light">
                          <i class="fa fa-arrow-up"></i> Back to top</a>
                        <div class="btn-group float-md-right ml-3">
                          <button type="button" class="btn btn-lg btn-light"> <span class="fa fa-arrow-left"></span> </button>
                          <button type="button" class="btn btn-lg btn-light"> <span class="fa fa-arrow-right"></span> </button>
                        </div>
                        <div class="dropdown float-md-right">
                          <label class="mr-2">View:</label>
                          <a class="btn btn-light btn-lg dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">12 <span class="caret"></span></a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">12</a>
                            <a class="dropdown-item" href="#">24</a>
                            <a class="dropdown-item" href="#">48</a>
                            <a class="dropdown-item" href="#">96</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div><div class="col-md-4 order-md-1 col-lg-3 sidebar-filter">
                  <h3 class="mt-0 mb-5">Showing <span class="text-primary">12</span> Products</h3>
                  <h6 class="text-uppercase font-weight-bold mb-3">Categories</h6>
                  <div class="mt-2 mb-2 pl-2">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="category-1">
                      <label class="custom-control-label" for="category-1">Dogs</label>
                    </div>
                  </div>
                  <div class="mt-2 mb-2 pl-2">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="category-2">
                      <label class="custom-control-label" for="category-2">Cats</label>
                    </div>
                  </div>
                  <div class="mt-2 mb-2 pl-2">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="category-3">
                      <label class="custom-control-label" for="category-3">Racoons</label>
                    </div>
                  </div>
                  
                  
                  <div class="divider mt-5 mb-5 border-bottom border-secondary"></div>
                  <h6 class="text-uppercase mt-5 mb-3 font-weight-bold">Price</h6>
                  <div class="price-filter-control">
                    <input type="number" class="form-control w-50 pull-left mb-2" value="50" id="price-min-control">
                    <input type="number" class="form-control w-50 pull-right" value="150" id="price-max-control">
                  </div>
                  <input id="ex2" type="text" class="slider " value="50,150" data-slider-min="10" data-slider-max="200" data-slider-step="5" data-slider-value="[50,150]" data-value="50,150" style="display: none;">
                  <div class="divider mt-5 mb-5 border-bottom border-secondary"></div>
                  <a href="#" class="btn btn-lg btn-block btn-primary mt-5">Update Results</a>
                </div>

              </div>
            </div>
 
    <?php



    function printproducts()
    {
        require("conn.php");
        /*
        $servername = "localhost";
        $username = "jiale";
        $password = "password";
        $dbname = "ict1004_assignment";


        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        */
        $sql = "SELECT * FROM `products`; ";
        $result = $conn->query($sql);
        
        global $productName, $productPrice, $productImage, $quantity, $description;

        if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) 
            for ($i = 0; $i < 9; $i++) {
                $row = $result->fetch_assoc();
                
                $productID = $row['product_id'];
                $productImage = $row['product_image'];
                $productName = $row['product_name'];
                $productPrice = $row['product_price'];
                $quantity = $row['product_quantity'];
                $description = $row['product_desc'];
                

            echo '<div class="col-6 col-md-6 col-lg-4 mb-3">';
            echo '<div class="card h-100">';
            echo '<img class="card-img-top" src="'. $productImage .'" alt="..." />';
            echo '<div class="card-body p-4">';
            echo '<div class="text-center">';
            echo '<h5 class="fw-bolder">'. $productName .'</h5>';
            echo '<span class="text-muted text-decoration-line-through">'. $productPrice .'</span>';
            echo '</div>';
            echo '</div>';
            echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
            echo '<div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id='. $row['product_id']. '">View options</a></div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

        
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    ?>


</body>
