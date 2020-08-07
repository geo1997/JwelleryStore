<?php include('server/server.php') ?>
<!DOCTYPE html>
<html>
 
  <head>
    <meta name="viewport" content=
    "width=device-width, initial-scale=1.0" />
    <title>
      Registration Page
    </title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href=
    "https://www.w3schools.com/w3css/4/w3.css" type="text/css" />
  </head>
  <body>

 
    <div class="top">
      <div class="logo">
        <img src="images/logo.png" width="200" alt="logo" />
      </div>
      <div class="name">
        <h1 align="center">
          THIEA ELEGANCE
        </h1>
        <div class="menu">
          <button class="abutton">
              <a href="../../home/homepage.html">	
            HOME
          </a>
          </button>
           <button class="abutton">ABOUT</button> 
           <button class="abutton">FAQ</button>
        </div>
        <div class="search-container">
          <form>
            <input type="text" name="search" placeholder=
            "Search.." />
          </form>
        </div>
      </div>
      <div class="log">
        <a href="../../log new/login.php"><img src="images/head.png" width=
        "50" height="50" alt="log" /></a>
      </div>
      <div class="user">
        <div class="wish">
          <a href="#"><img src="images/wish.png" width="35" height=
          "35" alt="w" /></a>
        </div>
        <div class="sign">
          <a href="#"><img src="images/sign.png" width="35" height=
          "35" alt="sign" /></a>
        </div>
        <div class="lan">
          <a href="#"><img src="images/lan.png" width="35" height=
          "35" alt="lang" /></a>
        </div>
      </div>
    </div>
    <div class="topnav" align="center">
      <p>
        If you already have an account with us, please login at the
        login page.
      </p>
    </div>
    <div class="vertical-menu1">
      <a href="#Catergory">CATERGORIES</a> <a href=
      "#Rings">RINGS</a> <a href="#Earrings">EARRINGS</a> <a href=
      "#Necklaces">NECKLACES</a> <a href="#Pendants">PENDANTS</a>
      <a href="#Watches">WATCHES</a> <a href="#b&amp;b">BRACELETS
      &amp;AMP BANGEL</a>
    </div>
    <div class="mid">
      <div class="new">
        <div class="side">
          <form action=register1.php name='registration'  id="registration" method="post">
            <div class="container">
              <h1>
                Register
              </h1>
              <p>
                Please fill in this form to create an account.
              </p>
              <hr />
              <?php include('error-msg/errors.php'); ?>
              <label for="fn"><strong>FIRST NAME</strong></label>
              <input type="text" placeholder="Enter First name"
              name="fn" required value="<?php echo $firstname; ?>">
              <br />
              <label for="ln"><strong>LAST NAME</strong></label>
              <input type="text" placeholder="Enter Last name"
              name="ln" required value="<?php echo $lastname; ?>">
              <br />
              <label for="email"><strong>Email</strong></label>
              <input type="email" placeholder="Enter Email" name=
              "email" required value="<?php echo $email; ?>">
              <br />
              <label for="tp"><strong>Telephone</strong></label>
              <input type="text" placeholder="Enter Telephone"
              name="tp" required value="<?php echo $tp; ?>">
              <br />
              <label for="ad"><strong>Your Address</strong></label>
              <input type="text" placeholder="Enter Address" name=
              "ad" required value="<?php echo $ad; ?>">
              <br />
              <label for="p"><strong>Postcode</strong></label>
              <input type="text" placeholder="Enter Postcode" name=
              "p" required value="<?php echo $p; ?>">
              <br />
              <label for="c"><strong>Country</strong></label>
              <input type="text" placeholder="Enter Country" name=
              "c" required value="<?php echo $c; ?>">
              <br />
              <label for="psw"><strong>Password</strong></label>
              <input type="password" placeholder="Enter Password"
              name="password_1" required />
              <br />
              <label for="psw-repeat"><strong>Repeat
              Password</strong></label> <input type="password"
              placeholder="Repeat Password" name="password_2"
              required />
              <hr />
              <p>
                By creating an account you agree to our <a href=
                "#">Terms &amp; Privacy</a>.
              </p><button type="submit" class=
              "registerbtn" name="reg_user">Register</button>
            </div>
            <div class="container signin">
              <p>
                Already have an account? <a href="#">Sign in</a>.
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="vertical-menu2">
      <a href="#">ABOUT</a> <a href="#">BRANCHES</a> <a href=
      "#">COLLECTIONS</a> <a href="#">WHAT'S NEW</a> <a href=
      "#">QUICK INQUIRY</a> <a href="#">CONTACT US</a>
    </div>
    <div class="footer">
      <br />
      <div class="ig">
        <a href="#"><img src="images/ig.png" width="30" alt=
        "ig" /></a>
      </div>
      <div class="fb1">
        <a href="#"><img src="images/fb.png" height="30" alt=
        "fb1" /></a>
      </div>
      <div class="wp">
        <img src="images/wp.png" height="30" alt="wp" />
      </div>
      <div class="pp">
        <a href="#"><img src="images/pp.png" width="30" alt=
        "pp" /></a>
      </div>
      <div class="visa">
        <img src="images/visa.png" height="30" alt="visa" />
      </div>
      <div class="mc">
        <img src="images/mc.png" height="30" alt="mc" />
      </div><br />
      <br />
      <h6>
        Copyright © 2018 THEIA ELEGANCE.com
      </h6><br />
    </div><script type="text/javascript">
//<![CDATA[
                        