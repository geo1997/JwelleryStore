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
<body>

	<p><br/></p>
	<p><br/></p>
	<p><br/></p>
	<div class="container-fluid">
	
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="card card-default">
					<div class="card-header"><h1>Customer Order details</h1></div>
					<div class="card-body">
						<?php
							include_once("db.php");
							$user_id = $_SESSION["user"];
							$orders_list = "SELECT o.order_id,o.user_id,o.product_id,o.qty,p.product_title,p.product_price,p.product_image FROM orders o,products p WHERE o.user_id='$user_id' AND o.product_id=p.product_id";
							$query = mysqli_query($con,$orders_list);
							if (mysqli_num_rows($query) > 0) {
								while ($row=mysqli_fetch_array($query)) {
									?>
										<div class="row">
											<div class="col-md-6">
												<img style="float:right;" src="product_images/<?php echo $row['product_image']; ?>" class="img-responsive img-thumbnail"/>
											</div>
											<div class="col-md-6">
												<table>
													<tr><td>Product Name</td><td><b><?php echo $row["product_title"]; ?></b> </td></tr>
													<tr><td>Product Price</td><td><b><?php echo "$ ".$row["product_price"]; ?></b></td></tr>
													<tr><td>Quantity</td><td><b><?php echo $row["qty"]; ?></b></td></tr>
													<tr><td>Transaction Id</td><td><b><?php echo $row["trx_id"]; ?></b></td></tr>
												</table>
											</div>
										</div>
									<?php
								}
							}
						?>
						
					</div>
					<div class="card-header"></div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</body>
</html>
















































