<!DOCTYPE html>
<html id="main">
  <head>
  	<link rel="stylesheet" href="css/style.css" type="text/css">
  	<link href="css/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
  	<meta charset="utf-8">
  </head>
  <body>
    <div class="center_install">
      <h4>NO DATABASE FOUND</h4>
      <h5>PLEASE, INSTALL THE DATABASE</h5>
    </div>
    <form action="install.php" method="POST">
      <div id="background_install" class="form-row">
        <div class="form-group col-md-6">
          <label for="Username">Mysql Root Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
        </div>

        <div class="form-group col-md-6">
          <label for="Password">Mysql Root Password</label>
          <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password" />
        </div>
      </div>
      <div class="center_install">
        <button type="submit" name="submit" class="btn btn-primary">Log In</button>
      </div>
    </form>
  </body>
</html>

<?php
if (isset($_POST["submit"])){
  $mysqlUserName = $_POST["username"];
  $mysqlPasswd = $_POST["passwd"];
  $dbFile = "academia.sql";
  $command='mysql -u' .$mysqlUserName .' -p' .$mysqlPasswd . ' < ' .$dbFile;
  exec($command, $output, $worked);
  switch($worked){
    case 0:
      echo "<div class='center_install_msg'>";
      echo "File <b>' .$dbFile.'</b> successfully imported to database<br/>";
      echo "Database user 'academia' created with password 'academiapass'<br/>";
      echo "Test user 'braisda@gmail.com' created with password 'admin'<br />";
      echo "<a href='index.php'>Proceed to Website</a><br />";
      echo "</div>";
      break;
  	case 1:
      echo "<div class='center_install_msg'>";
      echo 'There was an error during import: User already exists or you insert bad credentials<br/><br />';
      echo "</div>";
      break;
  }
}
?>
