<?php //Linking the configuration file
require 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
  <!-- Custome styles -->
  
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
    <div class="row">

    <div class="col-md-4 col-md-offset-4">

  <form  class="form" method="post" action="input.php">
   <h2 class="text-center">Add Product</h2>
   <hr>
   <div class="form-group">
   <label class="control-label">Name</label> <input type="text" name="name" class="form-control">
   <br></div>

    <?php 
     //TODO get weekdays from weekdays table and asign the results to  $result array.(2 lines)
    $sql="SELECT Jewelry_title FROM jewelry";
	$result=$conn->query($sql);
       if ($result->num_rows > 0) 
	   {
	?>
        <div class="lable">Select the date: <select name="jew">

    <?php while($row = $result->fetch_assoc()) 
	{

        //TODO Add option value, name accordingly (same line)
	
	?>
		
    	<option value="<?php echo $row['id']; ?>"><?php echo $row['Jewelry_title']; ?></option>

  <?php 
  }
  ?>
	
    </select></div>
	
    <?php 
  }
  ?>
	
    <br /><br>


    <?php 
    //TO DO get all the time list from timeslots table and asign to $result array(2 lines)
      $q="SELECT Collection_title FROM collection";
      $result2=$conn->query($q);
          if ($result2->num_rows > 0) 
        {
      ?>
        <div class="lable">Select the time :<select name="col">

    <?php while($row = $result2->fetch_assoc())
	{

      //TODO Add option value,name accordingly (same line)?>
     
      <option value="<?php echo $row['id']; ?>"><?php echo $row['Collection_title']; ?></option>

    <?php  
    }
    ?>
    </select></div>
    <?php 
    }
    ?>
    <br /><br>

    <div class="form-group">
   <label class="control-label">Price</label> <input type="text" name="price" class="form-control">
   <br></div>

   <div class="form-group">
   <label class="control-label">Description</label> <input type="text" name="desc" class="form-control">
   <br></div>

   <div class="form-group">
   <label class="control-label">image file name</label> <input type="text" name="img" class="form-control">
   <br></div>

   <div class="form-group">
   <label class="control-label">Keyword</label> <input type="text" name="key" class="form-control">
   <br></div>


    <input type="submit" value="Submit" name="btnSubmit"  class="btn btn-success btn-block"  >
    <input type="reset" value="Reset" class="btn btn-danger btn-block">
  </form>
<?php
if(isset($_POST["btnSubmit"]))
{
  // TODO :get all the post values(6 lines)
  $id=NULL;
  $name=$_POST['name'];
  $jew=$_POST['jew'];
  $col=$_POST['col'];
  $price=$_POST['price'];
  $desc=$_POST['desc'];
  $img=$_POST['img'];
  $key=$_POST['key'];
  

//TODO Complete sql query (same line)
  $sql= "INSERT INTO products VALUES('$id','$col','$jew','$name','$price','$desc','$img','$key')";
  $result=$conn->query($sql);
  
  //TODO the insertion 

  
    if(true)
	{
      echo "Inserted successfully";
    }
    else
	{
      echo "Error:". $conn->error;
    }
 }

 mysqli_close($conn);
 ?>
  </div>
  </div>
  </div>

</body>
</html>