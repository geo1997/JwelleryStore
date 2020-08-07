<?php  include 'config.php';
       
  if(isset($_GET["logout"]) === true )
  {
    session_unset(); 
  }

?>
<?php include(INCLUDE_PATH . "/logic/common_functions.php"); ?>

<!DOCTYPE html>
<html>
<head>
      
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          
    <link rel="stylesheet" type="text/css" href="css1/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     
    <script type="text/javascript" src="js1/respond.js"></script>

    <script type="text/javascript" src="Main.js"></script>

    <style>
    body{
        
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: scroll;
    }
    </style>
<body style="background-image: url('images/4.jpg');" >    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript" src="js1/respond.js"></script>

    <script type="text/javascript" src="Main.js"></script>

    <script type="text/javascript" src="js1/bootstrap.min.js"></script>
   
    <?php include(INCLUDE_PATH . "/layouts/messages.php") ?>    
      
 <header>
  
      <!-- Navigation Bar-->
      
      <nav class="navbar text-white navbar-expand-lg navbar-light bg-dark fixed-top ">
              <a class="navbar-brand text-white" href="#">MENU</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>      
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav mr-auto ">
                  <li  class="nav-item">
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
                  
                  <li  class="nav-item" >
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
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="cart_msg">
				<!--Cart Message--> 
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="card bg-secondary">
					<div class="card-header">Cart</div>
					<div class="card-body bg-white">
						<div class="row">
							
							<div class="col-md-2 col-xs-2"><b>Jewelry</b></div>							
							<div class="col-md-2 col-xs-2"><b>Quantity</b></div>
							<div class="col-md-2 col-xs-2"><b>Unit Price</b></div>
							<div class="col-md-2 col-xs-2"><b>Total Price in $</b></div>
                            <div class="col-md-2 col-xs-2"><b>Action</b></div>
						</div>
						<div id="cart_checkout"></div>
						<!-- DISPLAY CART ITEMS -->
						</div> 
					</div>
					
				</div>
                <div class="col-md-2"></div> 
			</div>
			
			
		</div>
        <div class="col-md-2"></div>
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














		