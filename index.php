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
    <title>THEIA ELEGANCE</title>
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custome styles -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
          
    <link rel="stylesheet" type="text/css" href="css1/bootstrap.min.css">        

    <link rel="stylesheet" type="text/css" href="style1.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript" src="js1/respond.js"></script>

    <script type="text/javascript" src="Main.js"></script>

    <script type="text/javascript" src="js1/bootstrap.min.js"></script>

    <style>
    body{
        
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: scroll;
        background-image: url('images/4.jpg');
    }
    </style>
    
  </head>

<body>


   
<?php include(INCLUDE_PATH . "/layouts/messages.php") ?>


<!--Header Begins From Here...style="background-image: url('images/4.jpg');"-->
<header>
<!--Top Header-->

    <!--<div class="top text-center text-white">
    <p><br></p>
    <h1><b>THEIA ELEGANCE</b></h1>
    <p>Resize this responsive page to see the effect!</p> 
    </div>-->

    


<!-- Navigation Bar-->

<nav class="navbar text-white navbar-expand-lg navbar-light bg-dark fixed-top ">
        <a class="navbar-brand text-white" href="#">MENU</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="nav navbar-nav mr-auto ">
            <li role="presentation" class="active">
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
            
            <li class="nav-item">
              <a class="nav-link text-white" href="store.php">Product</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="cart.php">CART</a> 
            </li>


        <!-- CART BUTTON-->

            <li class="nav-item"><a class="btn" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        
        <p><br></p>
        <p><br></p>

        <div class="jumbotron text-center text-white">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
          <h2>Golden Collection</h2>
            <img class="d-block w-100" src="images/03.jpg" alt="First slide">
          </div>
          <div class="carousel-item">
          <h2>Diamond Collection</h2>
            <img class="d-block w-100" src="images/07.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
          <h2>Platinum Collection</h2>
            <img class="d-block w-100" src="images/09.jpg" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      </div>

        <div class="jumbotron text-center">
            <h1>You Know What is Missing...</h1>
        </div>
        
        <div class="container">
        
			<div class="row">
                   
                            <div class="col-md-3 col-xs-2">
                                <div class="card  text-center">
                                    <div class="card-header text-white"><h5>GOLDEN COLLECTION</h5></div>		
                                        <div class="card-body bg-white">
                                            <img src="product_images/g2.jpg" alt="" style="width:200px; height:200px;">                                    
                                            <h4>PENDANT</h4>                                    
                                            <button class="btn btn-warning text-white"><a href="store.php">View More</a></button>                                
                                        </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-xs-2">
                                <div class="card bg-secondary text-center">
                                    <div class="card-header text-white"><h5>DIAMOND COLLECTION</h5></div>		
                                        <div class="card-body bg-white">
                                            <img src="product_images/d8.jpg" alt="" style="width:200px; height:200px;">                                    
                                            <h4>NECKLACE</h4>                                    
                                            <button class="btn btn-warning text-white"><a href="store.php">View More</a></button>                                
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-2">
                                <div class="card bg-secondary text-center">
                                    <div class="card-header text-white"><h5>SILVER<br>COLLECTION</h5></div>		
                                        <div class="card-body bg-white">
                                            <img src="product_images/s4.jpg" alt="" style="width:200px; height:200px;">                                    
                                            <h4>RINGS</h4>                                    
                                            <button class="btn btn-warning text-white"><a href="store.php">View More</a></button>                                
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-2">
                                <div class="card bg-secondary text-center">
                                    <div class="card-header text-white"><h5>PLATINUM COLLECTION</h5></div>		
                                        <div class="card-body bg-white">
                                            <img src="product_images/m9.jpg" alt="" style="width:200px; height:200px;">                                    
                                            <h4>WATCH</h4>                                    
                                            <button class="btn btn-warning text-white"><a href="store.php">View More</a></button>                                
                                        </div>
                                </div>
                            </div>                                               						
              				
            </div>
        </div>
            
<p><br></p>

        <div class="jumbotron">
        <div class="col-md-1 col-xs-2"></div>
        <div class="row text-center">           
            <img src="images/05.jpg" >
            <div class="col-ms-3 col-xs-2">
                <div class="card-body bg-white">
                <p><br></p>
                <p><br></p>
                <h1>LAYER ON ELEGANCE</h1>
                <p><br></p>
                <p><br></p>
                <h3>How many strands you use<br> is up to you.</h3>
                <p><br></p>                
                <button class="btn btn-warning text-white"><a href="store.php" class="text-white">SHOP NOW</a></button>
                <p><br></p>                
                </div>
            </div></div>                                  
        </div>

        <div class="jumbotron">
        
        <div class="row text-center">           
            
            <div class="col-ms-3 col-xs-2">
                <div class="card-body bg-white">
                <p><br></p>
                <p><br></p>
                <h1>REMIX CHARMS</h1>
                <p><br></p>
                <p><br></p>
                <h3>Make it personal by adding<br> one – or many – of<br> our new charms. </h3>
                <p><br></p>                
                <button class="btn btn-primary"><a href="store.php" class="text-white">SHOP NOW</a></button>
                <p><br></p>                
                </div>
            </div><img src="images/06.jpg" ></div>                                  
        </div>

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

            <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>
