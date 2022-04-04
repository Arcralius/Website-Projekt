# Website-Projekt

## V1.53
### Patch Notes
+ Switched orders.php away from ajax as it does not need to display content dynamically
+ Added additional validation to purchasing CRUD
+ Stocks for products are reduced after purchasing them
+ Added footer to all pages
+ Fixed formatting on most pages
+ Fixed footer styling (sticks to bottom now)
+ Fixed incorrect use of semantics (main element outside body)

## V1.52
### Patch Notes
+ Added ability to view order history via orders.php
+ Added "Orders" tab to navbar

## V1.51
### Patch Notes
+ Added ability to checkout and send order via payment.php and paymentProcessing.php
+ Added CRUD for orders
+ Added Footer for Checkout and promotion pages

## V1.50
### Patch Notes
+ Fixed errors on CRUD billing function 

## V1.49
### Patch Notes
+ Added payment delete function 
+ Updated the billing information page and all the CRUD functions

## V1.48
### Patch Notes
+ Added update and insert functionality for billing/payment info
+ Added some simple input validation for billing/payment form (except address)


## V1.47
### Patch Notes
+ Added products page (products.php)
+ Added individual product page (product.php) and added stock checking

## V1.46
### Patch Notes

+ Updated cart design
+ Added total cost to cart
+ Added Promotions (discounts for products) and factored it into cart cost
+ Updated Promotions CRUD on admin pages

## V1.45
### Patch Notes

+ Added user page 
+ Added input validation for user input
+ Added user edit last name, first name
+ Added user edit password
+ Added delete password
+ Added page redirect when not admin or logged in

## V1.44
### Patch Notes

+ CRUD functionality available for admin on orders, products, promotions table

## V1.43
### Patch Notes

+ Added cart and dynamic checkout page with Ajax
+ Implemented usage of db-config.ini
+ Edited paths for resources and redirects

## V1.42
### Patch Notes

+ Added admin console

## V1.41
### Patch Notes

+ Added session timeout

## V1.4
### Patch Notes

+ Added sessions 
+ Changed error messages
+ Added cookies for error messages
+ Edited login page
+ Edited fields to reflect new SQL changes

## V1.3
### Patch Notes

+ Sign in page
+ Register page
+ Regex for both sign in and register
+ Product list page
+ Pass id through URL for product
