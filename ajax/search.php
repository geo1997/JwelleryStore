<?php
    require 'connection.php';
    $output='';
//collect
if(isset($_POST['searchVal']))
{
    $searchq=$_POST['searchVal'];
    $searchq=preg_replace("#[^0-9a-z]#i","",$searchq);

    $query=mysqli_query($con,"SELECT * FROM products WHERE product_keywords LIKE'%$searchq%'OR product_title LIKE'%$searchq%'") or die(" could not search");
    $count=mysqli_num_rows($query);
    if($count==0)
    {
        $output='There was no search results';
    }
    else
    {
        while($row=mysqli_fetch_array($query))
        {
            $pro_id    = $row['product_id'];
			$pro_cat   = $row['product_collection'];
			$pro_brand = $row['product_jewelry'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];

        }

    }
}
echo "<p><br></p>
<div class='col-md-4'>
            <div class='card'>
                <div class='card-header'>$pro_title</div>
                <div class='card-body'>
                    <img src='product_images/$pro_image'  / style='width:120; height:240px;'>
                </div>
                <div class='card-header'>$.$pro_price.00
                    <button pid='$pro_id' style='float:right;' id='product' class='btn btn-danger btn-xs'>Add Cart</button>
                    <button pid='$pro_id' style='float:right;' id='product' class='btn btn-primary btn-xs'>Add Wishlist</button>
                </div>
            </div>
            <p><br></p>	
        </div>"	
?>