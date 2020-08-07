<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";

if(isset($_POST["category"])){
	$category_query = "SELECT * FROM Collection";
	$run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));
	echo "
		<ul class='list-group'>
		<li class='list-group-item list-group-item-dark'>COLLECTION</li>
	";
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$cid = $row["Collection_id"];
			$cat_name = $row["Collection_title"];
			echo "
					<li class='list-group-item list-group-item-action list-group-item-secondary'><a href='#' class='category' cid='$cid'>$cat_name</a></li>
			";
		}
		echo "</ul>";
	}
}
if(isset($_POST["brand"])){
	$brand_query = "SELECT * FROM Jewelry";
	$run_query = mysqli_query($con,$brand_query);
	echo "
	<ul class='list-group'>
	<li class='list-group-item list-group-item-dark'>JEWELRY</li>
	";
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$bid = $row["Jewelry_id"];
			$brand_name = $row["Jewelry_title"];
			echo "
			<li class='list-group-item list-group-item-action list-group-item-secondary'><a href='#' class='selectBrand' bid='$bid'>$brand_name</a></li>
			";
		}
		echo "</ul>";
	}
}
if(isset($_POST["page"])){
	$sql = "SELECT * FROM products";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	$pageno = ceil($count/12);
	for($i=1;$i<=$pageno;$i++){
		echo "
			<button class='btn-xs'><a href='#' page='$i' id='page'>$i</a></button>
		";
	}
}
if(isset($_POST["getProduct"])){
	$limit = 12;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
	$product_query = "SELECT * FROM products LIMIT $start,$limit";
	$run_query = mysqli_query($con,$product_query);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_collection'];
			$pro_brand = $row['product_jewelry'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
			echo "
				<div class='col-md-4'>
							<div class='card'>
								
								<div class='card-body'>
									<img src='product_images/$pro_image' style='width:240px; height:240px;'/>
								</div>
								<div class='card-header bg-secondary' style='float:left;'>									
								<div class='row'>
									<div class='col-md-1'></div>
									<button pid='$pro_id'  id='product' class='btn btn-dark btn-xs'>AddToCart</button>
									<div class='col-md-1'></div>
									<button class='btn btn-dark btn-xs style='float:left;''>View</button>
								</div></div>
							</div>
							<p><br></p>	
						</div>
						
			";
		}
	}
}



if(isset($_POST["get_seleted_Category"]) || isset($_POST["selectBrand"]) || isset($_POST["search"])){
	if(isset($_POST["get_seleted_Category"])){
		$id = $_POST["cat_id"];
		$sql = "SELECT * FROM products WHERE product_collection = '$id'";
	}else if(isset($_POST["selectBrand"])){
		$id = $_POST["brand_id"];
		$sql = "SELECT * FROM products WHERE product_jewelry = '$id'";
	}else{
		$keyword = $_POST["keyword"];
		$sql = "SELECT * FROM products WHERE product_keywords LIKE '%$keywordq%'";
	}
	
	$run_query = mysqli_query($con,$sql);
	while($row=mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_collection'];
			$pro_brand = $row['product_jewelry'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
			echo "
				<div class='col-md-4'>
							<div class='card'>
								
								<div class='card-body'>
									<img src='product_images/$pro_image' style='width:240px; height:240px;'/>
								</div>
								<div class='card-header' style='float:left;'>									
									
								<button pid='$pro_id' style='float:left;' id='product' class='btn btn-secondary btn-xs'>AddToCart</button>
									<button class='btn btn-dark btn-xs'>View</button>
								</div>
							</div>
							<p><br></p>	
						</div>
						
			";
		}
	}
	

	if(isset($_POST["addToCart"])){
		

		$p_id = $_POST["proId"];
		

		if(isset($_SESSION["uid"])){

		$user_id = $_SESSION["uid"];

		$sql = "SELECT * FROM cart WHERE p_id = '$p_id' AND user_id = '$user_id'";
		$run_query = mysqli_query($con,$sql);
		$count = mysqli_num_rows($run_query);
		if($count > 0){
			echo "
				<div class='alert alert-warning'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Product is already added into the cart Continue Shopping..!</b>
				</div>
			";//not in video
		} else {
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','$user_id','1')";
			if(mysqli_query($con,$sql)){
				echo "
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Product is Added..!</b>
					</div>
				";
			}
		}
		}else{
			$sql = "SELECT id FROM cart WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1";
			$query = mysqli_query($con,$sql);
			if (mysqli_num_rows($query) > 0) {
				echo "
					<div class='alert alert-warning'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is already added into the cart Continue Shopping..!</b>
					</div>";
					exit();
			}
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','-1','1')";
			if (mysqli_query($con,$sql)) {
				echo "
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Your product is Added Successfully..!</b>
					</div>
				";
				exit();
			}
			
		}
		
		
		
		
	}

	//Remove Item From cart
	if (isset($_POST["removeItemFromCart"])) {
		$remove_id = $_POST["rid"];
		if (isset($_SESSION["uid"])) {
			$sql = "DELETE FROM cart WHERE p_id = '$remove_id' AND user_id = '$_SESSION[uid]'";
		}else{
			$sql = "DELETE FROM cart WHERE p_id = '$remove_id' AND ip_add = '$ip_add'";
		}
		if(mysqli_query($con,$sql)){
			echo "<div class='alert alert-danger'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is removed from cart</b>
					</div>";
			exit();
		}
	}



//Count User cart item
if (isset($_POST["count_item"])) {
	//When user is logged in then we will count number of item in cart by using user session id
	if (isset($_SESSION["user"])) {
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE user_id = $_SESSION[user]";
	}else{
		//When user is not logged in then we will count number of item in cart by using users unique ip address
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = '$ip_add' AND user_id < 0";
	}
	
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query);
	echo $row["count_item"];
	exit();
}
//Count User cart item

//Get Cart Item From Database to Dropdown menu
if (isset($_POST["Common"])) {

	if (isset($_SESSION["uid"])) {
		//When user is logged in this query will execute
		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$_SESSION[uid]'";
	}else{
		//When user is not logged in this query will execute
		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.ip_add='$ip_add' AND b.user_id < 0";
	}
	$query = mysqli_query($con,$sql);
	if (isset($_POST["getCartItem"])) {
		//display cart item in dropdown menu
		if (mysqli_num_rows($query) > 0) {
			$n=0;
			while ($row=mysqli_fetch_array($query)) {
				$n++;
				$product_id = $row["product_id"];
				$product_title = $row["product_title"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$qty = $row["qty"];
				echo '
				<div class="row">
					<div class="col-md-1">'.$n.'</div>
					<div class="col-md-4"><img class="img-responsive" src="product_images/'.$product_image.'" style="width:120px; height:120px;" style="float:left;"/></div>
					<div class="col-md-3">'.$product_title.'</div>
					<div class="col-md-3">$'.$product_price.'</div>
				</div>';
				
			}
			?>
				<a style="float:right;" href="cart.php" class="btn btn-warning">Edit&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span></a>
			<?php
			exit();
		}
	}
	if (isset($_POST["checkOutDetails"])) {
		if (mysqli_num_rows($query) > 0) {
			//display user cart item with "Ready to checkout" button if user is not login
			echo "<form method='post' action='login.php'>";
				$n=0;
				while ($row=mysqli_fetch_array($query)) {
					$n++;
					$product_id = $row["product_id"];
					$product_title = $row["product_title"];
					$product_price = $row["product_price"];
					$product_image = $row["product_image"];
					$cart_item_id = $row["id"];
					$qty = $row["qty"];

					echo '<p><br></p>
						<div class="row">								
								<input type="hidden" name="product_id[]" value="'.$product_id.'"/>
								<input type="hidden" name="" value="'.$cart_item_id.'"/>
								<div class="col-md-2"><h6>'.$product_title.'</h6><img class="img-responsive" src="product_images/'.$product_image.'" style="width:120px; height:120px;" style="float:middle;"/></div>								
								<div class="col-md-2" ><input type="text" class="form-control qty" value="'.$qty.'"  ></div>
								<div class="col-md-2"><input type="text" class="form-control price" value="'.$product_price.'" readonly="readonly"></div>
								<div class="col-md-2"><input type="text" class="form-control total" value="'.$product_price.'" readonly="readonly"></div>
								<div class="col-md-2"><div class="btn-group">
									<a href="#" remove_id="'.$product_id.'" class="btn btn-danger remove">REMOVE</a>
								</div></div>											
							</div>';
				}
				
				echo '<div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-4">
								<b class="net_total" style="font-size:20px;"> </b>
					</div>';
				if (!isset($_SESSION["user"])) {
					echo '<input type="submit" style="float:right;" name="login_user_with_product" class="btn btn-info btn-lg" value="Ready to Checkout" >
							</form>';
					
				}else if(isset($_SESSION["user"])){
					//Paypal checkout form
					echo '
						</form>
						<form action="billl.php" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="">
							<input type="hidden" name="upload" value="1">';
							  
							$x=0;
							$sql = "SELECT a.product_id,
										a.product_title,
										a.product_price,
										a.product_image,
										b.id,b.qty 
							FROM products a,cart b 
							WHERE a.product_id = b.p_id ";
							
							$query = mysqli_query($con,$sql);
							while($row=mysqli_fetch_array($query)){
								$x++;
								echo  	
									'<input type="hidden" name="item_name_'.$x.'" value="'.$row["product_title"].'">
								  	 <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
								     <input type="hidden" name="amount_'.$x.'" value="'.$row["product_price"].'">
								     <input type="hidden" name="quantity_'.$x.'" value="'.$row["qty"].'">';
								}
							  
							echo   
								'
									<input type="submit" style="float:right;margin-right:80px;" name="submit1"
										alt="Checkout" class="btn btn-info btn-lg" value="Checkout">
								</form>';
				}
			}
	}
	
	
}
?>
