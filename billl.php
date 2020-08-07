<?php  include 'config.php';
        

  if(isset($_GET["logout"]) === true )
  {
    session_unset(); 
  }

?>
<?php include(INCLUDE_PATH . '/logic/userSignup.php'); ?>

<!DOCTYPE html>
<html>
<head>
      
    <meta charset="utf-8">

    <title>UserAccounts - Sign up</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
    <link rel="stylesheet" type="text/css" href="css1/bootstrap.min.css">

    </script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     
    <script type="text/javascript" src="js1/respond.js"></script>

    <script type="text/javascript" src="Main.js"></script>

    <style>
    body{
        
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: scroll;
    }
    </style>
      
</head>
<body style="background-image: url('images/4.jpg');">

    <script type="text/javascript" src="js1/bootstrap.min.js"></script>
    <nav class="navbar text-white navbar-expand-lg navbar-light bg-dark fixed-top ">
        <a class="navbar-brand text-white" href="#">MENU</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="nav navbar-nav mr-auto ">
            <li role="presentation">
            <a class="nav-link text-white" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#">About</a>
            </li>
            <li role="presentation">
              <a class="nav-link text-white" href="#">FAQ</a>
            </li>            
            <li class="nav-item">
              <a class="nav-link text-white" href="#">Contact Us</a>
            </li>
            
            <li class="nav-item" >
              <a class="nav-link text-white" href="store.php">Product</a>
            </li>

            <li role="presentation" class="active">
                <a class="nav-link text-white" href="cart.php">CART</a> 
            </li>


        <!-- CART BUTTON-->

            <li "nav-item"><a class="btn" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    WISHLIST</a>
                    <ul class="dropdown-menu" style="float:right;">
                     <div class="card border-success mb-3" style="width: 30rem;" >
                        <div class="card-header">
                                <div class="row">
                                        <div class="col-md-2">No</div>
                                        <div class="col-md-3" >Product Image</div>
                                        <div class="col-md-3">Product Name</div>
                                        <div class="col-md-3">Price in $.</div>
                                    </div>
                        </div>
                        <div class="card-body">
                            <div id="cart_product">
                            <div class="row" >
                            <!-- DISPLAY CART -->
                            </div>                                       
                        </div>
                        </div>
                    </ul>
                </li>
                
          </ul>

      <!-- SEARCH-->

          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="search_btn">Search</button>
          </form>

     <!-- SIGN UP-->         
     
          
          <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>

        </li>

        
     </ul>
        </div>
      
      </nav>

</header>

	<p><br/></p>
    <p><br/></p>
    <p><br></p>

  <div class="container">
    <div class="row">
    <div class="col-md-1 col-md-offset-4"></div>
      <div class="col-md-4 col-md-offset-4 bg-dark">
        <form class="form text-white " action="pay" method="post" enctype="multipart/form-data">

        <h3>Billing Address</h3>

        <div class="form-group ">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="542 W. 15th Street" class="form-control" required>
        </div>

        <div class="form-group ">
        <label for="city">City</label>
        <input type="text" id="city" name="city" placeholder="Nawalapitiya" class="form-control" required>
        </div>

        <div class="form-group ">
        <label for="district">District</label>
        <input type="text" id="district" name="district" placeholder="Kandy" class="form-control" required>
        </div>

        <div class="form-group ">
        <label for="postalcode">Postal code</label>
        <input type="text" id="postalcode" name="postalcode" placeholder="20000" class="form-control" required>
        </div>


        <div class="form-group ">
        <label for="zip">Zip</label>
        <input type="text" id="zip" name="zip" placeholder="10001" class="form-control" required>
        </div>

        <label>
          <input type="checkbox" checked="checked" name="address"> Shipping address same as billing
        </label>

        <div class="form-group">
            <button type="submit1" name="submit1" class="btn btn-success btn-block" required>"Done"</button>
          </div>

        </form> 
        </div>

        <div class="col-md-2 col-md-offset-4"></div>

        <div class="col-md-4 col-md-offset-4 bg-white">

        <form class="form text-dark" id="pay" action="billl.php" method="post" enctype="multipart/form-data">

        <h3>Payment</h3>
        <div class="form-group " >        

        <div class="form-group ">
        <label for="cname">Name on Card</label>
        <input type="text" id="cname" name="cname" placeholder="John More Doe" class="form-control" required>
        </div>

        <label for="fname">Accepted Cards</label>
        <div class="form-inline" class="form-control">
          <select id="card" name="card" class="form-control" >      
            <option value="visa" selected="selected">VISA<img src="assets/images/visa.jpg" id="visa"></option>
            <option value="AmericanExpress">AmericanExpress</option>
            <option value="Mastercard">MasterCard</option>
            <option value="Discover">Discover</option>
          </select>
          </div>
        </div>

        <div class="form-group ">
        <label for="ccnum">Credit card number</label>
        <input type="text" id="ccnum" name="ccnum" placeholder="1111-2222-3333-4444" class="form-control" required>
        </div>

        <div class="form-group ">
        <label for="expmonth">Exp Month</label>            
            <select id="expmonth" name="expmonth" class="form-control">
                            <option value="01">January</option>
                            <option value="02">February </option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12" selected="selected">December</option>
                        </select>
        </div>

        <div class="form-group ">
        <label for="expyear">Exp Year</label>    
        <select id="expyear" name="expyear" class="form-control">
                            <option value="16" selected="selected"> 2016</option>
                            <option value="17"> 2017</option>
                            <option value="18"> 2018</option>
                            <option value="19"> 2019</option>
                            <option value="20"> 2020</option>
                            <option value="21"> 2021</option>
                        </select>
        </div>

        <div class="form-group ">
        <label for="cvv">CVV</label>
        <input type="text" id="cvv" name="cvv" placeholder="352" class="form-control" required>
        </div>        

        <div class="form-group">
            <button type="submit1" name="submit1" class="btn btn-success btn-block" required href="order.php"> "Purchase"</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

<p><br></p>
<!-- Footer -->

<footer class="bg-dark text-white sticky-bottom">
<p><br></p>
    <div class="footer-top" id="footer-top">
        <div class="container">
            <div class="row">
                
                <div class="col-md-3 footer-links" id="space">
                    <div class="row">
                        <div class="col">
                            <h4>Get to Know Us</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p><a class="text-white" href="#" style="text-decoration: none;">Company</a></p>
                            <p><a href="#" class="text-white" style="text-decoration: none">Contact</a></p>
                            <p><a href="#" class="text-white" style="text-decoration: none">FAQ</a></p>
                            <p><a href="#" class="text-white" style="text-decoration: none">Blog</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 footer-contact" id="space">
                    <h4>Contact</h4>
                    <p><i class="fas fa-map-marker-alt"></i> No. 151 Galle Road,<br> Colombo 00300,<br> Sri Lanka. </p>
                    <p><i class="fas fa-phone"></i> Phone: +94 7755 44651 </p>
                    <p><i class="fas fa-envelope"></i> Email: <a href="info@theiaelegance.lk" class="text-dark" style="text-decoration: none">info@theiaelegance.lk</a></p>
                    <!--<p><i class="fab fa-skype"></i> Skype: you_online</p>-->
               </div>
                
                <div class="col-md-3 col-lg-3 footer-social" id="space">
                    <h4>Follow us</h4>
                    <p> <a href="#" id="social" class="text-white">facebook</a></p>
                    <p> <a href="#" id="social" class="text-white">twitter</a></p>
                    <p> <a href="#" id="social" class="text-white">google</a></p>
                    <p> <a href="#" id="social" class="text-white">instagram</a></p>
                    
                </div>

                <div class="col-md-3" id="sub-box">
                    <form action="#">
                        <div class="form-group">
                        <label for="email" id="sub-box">Want to see more latest Products &amp; Offers?</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
                        </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-info">Subcribe Now!</button>
                    </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    
    <div class="footer-bottom " >
        <div class="container-fluid text-dark bg-secondary " style="float:left;">
            <div class="row">
                   <div class="container text-center" >
                    <p id="copy-name" >Copyrights &copy; 2018 THEIA ELEGANCE. All Rights Reserved by <a id="copy-name">THEIA ELEGANCE</a></p>
                </div>

               </div>
        </div>
    </div>
    
</footer>
<!--Footer is finished-->

</body>
</html>

