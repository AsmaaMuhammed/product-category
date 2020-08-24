<!-- the whole site is wrapped in a container div to give it some margin on the sides -->
<!-- closing container div can be found in the footer -->
<div class="container">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#"><?php echo TITLE; ?></a>
          <?php if (isset($_SESSION['user'])): ?>
              <a class="navbar-brand" href="../../admin/categories/list.php">Categories</a>
              <a class="navbar-brand" href="../../admin/products/list.php">Products</a>
          <?php endif; ?>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <?php if (isset($_SESSION['user'])): ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['user']['username'] ?>
                <span class="caret"></span>
            </a>

              <ul class="dropdown-menu">
                  <li><a href="<?php echo BASE_URL . 'logout.php' ?>" style="color: red;">Logout</a></li>
              </ul>
          </li>
        <?php else: ?>
          <!-- <li><a href="<?php echo BASE_URL . 'signup.php' ?>"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
          <li><a href="<?php echo BASE_URL . 'login.php' ?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>