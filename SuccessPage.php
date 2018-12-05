<?php
if (!$_POST) {
  ?>
  <script type = "text/javascript">
    window.location.pathname = '/Login.php'
  </script>
  <?php
}
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Eagle Events | Sign Up</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="#.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>E</b>LE</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Eagle</b>Events</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
  </header>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

<?php
/*
If it is a success, display a link to the login page

If it fails, say what the problem was (username taken, or whatever).
Link back to sign up page.

Ideally display problems on Sign-up page after clicking submit.
*/
$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$year = $_POST['year'];
$conn = mysqli_connect("localhost","root",
"Eagle123", "eagleEvents");
 if (mysqli_connect_errno()){
   printf("Connect failed: %s\n", mysqli_connect_error());
   exit(1);
 }

// Check is username already exists
$queryCheckUN = "SELECT uid FROM user WHERE username = '$username'";
$result = mysqli_query($conn, $queryCheckUN);
$result = mysqli_fetch_assoc($result);
if($result['uid'] != '') {
  //print "user exists";
  ?>
  <script type = "text/javascript">
    window.location.pathname = '/SignUp.php'
    alert("Username already exists.");
</script>
  <?php
}
// Check if username is the correct length
else if(strlen($username) < 5 || strlen($username) > 16) {
  //print "incorrect length for user";
  ?>
  <script type = "text/javascript">
    window.location.pathname = '/SignUp.php'
    alert("Username must be 6 characters");
  </script>
  <?php
}
// Check if email is Emory official
else if(!(preg_match("/@emory.edu/", $email) )) {
  //print "use emory email";
  ?>
  <script type = "text/javascript">
      window.location.pathname = '/SignUp.php'
      alert("Use Emory Email");
  </script>
  <?php

}
// Check if password is at least 8 characters
else if(strlen($password) < 8){
  //print "too short password";
  ?>
     <script type = "text/javascript">
      window.location.pathname = '/SignUp.php'
      alert("Password must be 8 characters");
  </script>
  <?php
}
else if(strlen($password) > 16) {
  //print "too long password";
  ?>
     <script type = "text/javascript">
      window.location.pathname = '/SignUp.php'
      alert("Password cannot exceed 16 characters");
  </script>
  <?php
}
// Check if password has lower and uppercase letters
else if(!(preg_match("/[a-z]+[A-Z]+/", $password))){
  //print "upper lower case";
   ?>
     <script type = "text/javascript">
      window.location.pathname = '/SignUp.php'
      alert("Password must include lower and uppercase letters");
  </script>
  <?php
}
// Check if password has at least one special character
else if(!(preg_match("/[^a-zA-Z0-9]/", $password))){
  //print "special character";
 ?>
     <script type = "text/javascript">
      window.location.pathname = '/SignUp.php'
      alert("Password must include a special character");
  </script>
  <?php

}
// Check if password has at least one number
else if(!(preg_match("/\d+/", $password))){
  //print "number";
  ?>
     <script type = "text/javascript">
      window.location.pathname = '/SignUp.php'
      alert("Password must include a number");
  </script>
  <?php
}
// Check if inputed passwords match
else if(strcmp($password,$password2) != 0){
  //print (strcmp($password,$password2));
  //print "<br><h1>Inputed passwords don't match</h1><br>";

  ?>
     <script type = "text/javascript">
      window.location.pathname = '/SignUp.php'
      alert("Passwords must match");
  </script>
  <?php

}
// No issues - create user account in database
else {
  //print "create";

   $query = "SELECT MAX(uid) AS max FROM user;";
   if ( ! ( $result = mysqli_query($conn, $query)) ) {
     printf("Error: %s\n", mysqli_error($conn));
     exit(1);
   }
   $newUserId = mysqli_fetch_assoc($result);
   $newUserId = $newUserId['max'] + 1;

   $query2 = "INSERT INTO user VALUES('$newUserId', '$username', '$password');";
   if ( ! ( $result2 = mysqli_query($conn, $query2)) ) {
     print("<h4> Error1. Signup Failed. </h4>\n");
     exit(1);
   }

   $query3 = "INSERT INTO student VALUES('$fname', '$lname', '$year', '$email', '$newUserId', 'userprofilepictures/DefaultImage.png');";
   if ( ! ( $result3 = mysqli_query($conn, $query3)) ) {
     print("<h4> Error2. Signup Failed. </h4>\n");
     exit(1);
   }

   print "      <h1>\n";
   print "        Account Created. Welcome to Eagle Events!\n";
   print "      </h1>\n";

}
?>
</section>

<!-- Main content -->
<section class="content container-fluid">

  <!--
    | Your Page Content Here |
    -------------------------->

    <div class="container">
 <h3>

 </h5>
    <form action = "Login.php" method = "POST">
      <br><br>
      <button type = "Submit" class = "btn btn-primary"> Click here to log in! </button>
    </form>
 </h5>
</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
<!-- To the right -->
<div class="pull-right hidden-xs">
  Anything you want
</div>
<!-- Default to the left -->
<strong>Copyright © 2018 <a href="#">EagleEvents</a>.</strong> All rights reserved.
</footer>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
 Both of these plugins are recommended to enhance the
 user experience. -->
</body>
</html>;
