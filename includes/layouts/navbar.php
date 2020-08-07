<!-- the whole site is wrapped in a container div to give it some margin on the sides -->
<!-- closing container div can be found in the footer -->
<div >
  <nav class="navbar navbar-default">
    <div>
     <!-- <div class="navbar-header">
        <a class="navbar-brand" href="#">UserAccounts</a>
      </div>
       <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Page 1</a></li>
        <li><a href="#">Page 2</a></li>
      </ul> -->
      <ul class="nav navbar-nav navbar-right">
        <?php if (isset($_SESSION['user'])): ?>
          <li class="dropdown">
            <button class="dropdown-toggle btn btn-warning" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['user']['username'] ?></button>

              <?php if (isAdmin($_SESSION['user']['id'])): ?>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo BASE_URL . 'admin/profile.php' ?>">Profile</a></li>
                  <li><a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">Dashboard</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="<?php echo BASE_URL . 'logout.php' ?>" style="color: red;">Logout</a></li>
                </ul>
              <?php else: ?>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo BASE_URL . 'logout.php' ?>" style="color: red;">Logout</a></li>
                </ul>
              <?php endif; ?>
          </li>
        <?php else: ?> 

          <li><button class="btn btn-secondary text-white" role="button"  aria-haspopup="true" aria-expanded="false">
          <a class="btn-link text-white" href="<?php echo BASE_URL . 'signup.php' ?>">Sign Up</a></button></li>

          <li><button class="btn btn-secondary text-white" role="button"  aria-haspopup="true" aria-expanded="false">
          <a class="btn-link text-white" href="<?php echo BASE_URL . 'login.php' ?>">Login</a></button></li>
          
        <?php endif; ?>
      </ul>
    </div>
  </nav>