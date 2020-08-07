<?php

  if(isset($_POST["submit1"]) === true)
  {
    $address = $_POST['address'];    
    $city1 = $_POST['city'];
    $district1 = $_POST["district"];
    $postalCode1 = $_POST["postalcode"];
    $cname = $_POST["cname"];
    $card = $_POST["card"];
    $cnumber = $_POST["ccnum"];
    $exp = $_POST["expyear"];       
    $cvv = $_POST["cvv"];    
    $faddress =  $address." ".$city1." ".$district1;
    
    //"UPDATE user payment";
    $sql = "UPDATE users SET 
            shipping address = '".$faddress."' ,
            postal code = '".$postalCode1."',
            card holder name = '".$cname."',
            card type = '".$card."',
            card number = '".$cnumber."',
            exp date = '".$exp."', 
            ccv = '".$cvv."';" ;

            $result=$conn->query($sql);
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