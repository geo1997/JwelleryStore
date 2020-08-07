<?php 
  session_start();
  
  //echo $_SESSION["S-email"];
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://v40.pingendo.com/assets/4.0.0/default/theme.css" type="text/css"> </head>

<body>
  <div class="py-5" style="background-color: grey;">
    <div class="container">
      <div class="row">
        <div class="align-self-center col-md-6 text-white">
          <h1 class="text-center text-md-left display-3">Sparkle.lk</h1>
          <p class="lead">Why waiting if you can do it online?</p>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body p-5">
              <h3 class="pb-3">Billing Information</h3>
              <form action="BillInfo.php" method="post" >
                <div class="form-group">
                  <label for="exampleInputEmail1">Address Line1</label>
                  <input type="text" class="form-control" id="inlineFormInput" placeholder="houseNumber-Street" name="address1"> </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Address Line2</label>
                  <input type="text" class="form-control" id="inlineFormInput" placeholder="Town" name="address2"> </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">City</label>
                  <input type="text" class="form-control" id="inlineFormInput" placeholder="City" name="city"> </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">PostalCode</label>
                  <input type="text" class="form-control" id="inlineFormInput" placeholder="xxxxxx" name="postalcode"> </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">CreditCardNumber</label>
                  <input type="text" class="form-control" id="inlineFormInput" placeholder="XXXX-XXXX-XXXX-XXXX" name="CCnumber"> </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">CVC</label>
                  <input type="text" class="form-control" id="inlineFormInput" placeholder="Jane Doe" name="cvc"> </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">ExpiaryDate</label>
                  <input type="text" class="form-control" id="inlineFormInput" placeholder="MM/YY" name="expdate"> </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Credit Card Type</label>
                  <select class="custom-control custom-select" name="CCType">
                    <option selected="">Open this select menu</option>
                    <option value="visa">Visa</option>
                    <option value="americanExpress">AmericanExpress</option>
                    <option value="Mastercard">MasterCard</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Country : SriLanka Only</label>
                </div>
                <button type="submit" class="btn mt-2 btn-outline-dark" name = "submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <pingendo onclick="window.open('https://pingendo.com/', '_blank')" style="cursor:pointer;position: fixed;bottom: 10px;right:10px;padding:4px;background-color: #00b0eb;border-radius: 8px; width:250px;display:flex;flex-direction:row;align-items:center;justify-content:center;font-size:14px;color:white">Made with Pingendo Free&nbsp;&nbsp;
    <img src="https://pingendo.com/site-assets/Pingendo_logo_big.png" class="d-block" alt="Pingendo logo" height="16">
  </pingendo>
</body>

</html>


<?php

  if(isset($_POST["submit"]) === true)
  {
    $Address1 = $_POST["address1"];
    $Address2 = $_POST["address2"];
    $city = $_POST["city"];
    $postalCode = $_POST["postalcode"];
    $CCnumber = $_POST["CCnumber"];
    $cvc = $_POST["cvc"];
    $expiary = $_POST["expdate"];
    $CCType = $_POST["CCType"];
    $Address =  $Address1." ".$Address2." ".$city." ".$postalCode;
    
    //$sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
    $sql = "UPDATE user SET 
            Address = '".$Address."' , CardNumber = '".$CCnumber."', Cvc = '".$cvc."', Expires = '".$expiary."', CCtype = '$CCType' WHERE email = '".$_SESSION["S-email"]."';" ;
    
      if ($conn->query($sql) === TRUE) {
       
       
      echo '<script type="text/javascript">
              window.location = "http://localhost/j2/index.php"
              </script>';
        
       
        
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        
      }
    

  };
  


?>