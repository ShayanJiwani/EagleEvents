<?php
// start session and get rid of any information that was in our session
// essentially a log out any time you get to this page
session_start();
$_SESSION = array();
session_destroy();
// post data from same page on login
if ($_POST != NULL) {
  $conn = mysqli_connect("localhost","root",
  "Eagle123", "eagleEvents");
  if (mysqli_connect_errno()){
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit(1);
  }
  $username = $_POST['username'];
  $password = $_POST['password'];
  $errString = "";
  // check if user exists
  $queryUID = "SELECT uid FROM user WHERE username = '$username' AND password = '$password'";
  if ( ! ( $result = mysqli_query($conn, $queryUID)) ) {
   printf("Error: %s\n", mysqli_error($conn));
   exit(1);
  }
  // if it doesn't, we will need to tell them they made an error
  if (mysqli_num_rows($result) == 0) {
    // write errors
    $errString = "*Username or password incorrect. Please try again.";
  }
  // otherwise we get their information, store it in session vars, and then
  // redirect to the Home Page
  else {
    session_start();
    $uid = mysqli_fetch_assoc($result);
    $uid = $uid["uid"];
    $queryInfo = "SELECT fname, lname, picture FROM student WHERE uid = '$uid'";
    if ( ! ( $result2 = mysqli_query($conn, $queryInfo)) ) {
      printf("Error: %s\n", mysqli_error($conn));
      exit(1);
    }
    $name = mysqli_fetch_assoc($result2);
    $fname = $name['fname'];
    $lname = $name['lname'];
    $picture = $name['picture'];

    $_SESSION['uid'] = $uid;
    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['picture'] = $picture;
    // add redirect here. POST array contains username + password
    ?>
    <script type = "text/javascript">
      window.location.pathname = '/HomePage.php'
    </script>
    <?php
    print("<p>user DOES exist</p>");
  }
  mysqli_close($conn);
  if ($_POST['success']) {
    print ($_POST['success']);
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EagleEvents | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Eagle</b>Events</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php
    if ($errString != "") {
      printf("<p style=\"color:red;\">". $errString ."</p>\n");
    }
    ?>
    <form action="Login.php" method="POST">
      <div class="form-group has-feedback">
        <input type="text" name = "username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name = "password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-xs-8">
            <div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
    </form>


    <a href="SignUp.php" class="text-center">Sign up for an account.</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
</body>
</html>
