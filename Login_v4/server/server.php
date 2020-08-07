<?php
session_start();
require ('connection.php');
// initializing variables
$firstname = "";
$lastname = "";
$email    = "";
$tp   = "";
$ad    = "";
$p  = "";
$c = "";
$errors = array(); 



// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $firstname = mysqli_real_escape_string($db, $_POST['fn']);
    $lastname = mysqli_real_escape_string($db, $_POST['ln']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $tp = mysqli_real_escape_string($db, $_POST['tp']);
    $ad = mysqli_real_escape_string($db, $_POST['ad']);
    $p = mysqli_real_escape_string($db, $_POST['p']);
    $c = mysqli_real_escape_string($db, $_POST['c']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


    if (empty($firstname)) { array_push($errors, "Firstname is required"); }
    if (empty($lastname)) { array_push($errors, "Lastname is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($ad)) { array_push($errors, "Address is required"); }
    if (empty($tp)) { array_push($errors, "Telephone is required"); }
    if (empty($p)) { array_push($errors, "Postcode is required"); }
    if (empty($c)) { array_push($errors, "Country is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) 
    {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure 
  // a user does not already exist with the same  email
  $user_check_query = "SELECT * FROM user_reg WHERE  email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user)
   { // if user exists
    if ($user['email'] === $email) 
    {
      array_push($errors, "Email already exists");
      
    }
    
  }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0) {
    $password = md5($password_1);//encrypt the password before saving in the database

    $query = "INSERT INTO user_reg (firstname,lastname,email,telephone,address,postcode,country,password) 
              VALUES('$firstname','$lastname', '$email','$tp','$ad','$p','$c','$password')";
    mysqli_query($db, $query);
    $_SESSION['email'] = $email;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
}
}



if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM user_reg WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['email'] = $email;
          $_SESSION['success'] = "You are now logged in";
          header('location: index.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }
  ?>