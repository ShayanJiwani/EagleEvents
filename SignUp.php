<?php
if ($_POST != NULL) {
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
  mysqli_close($conn);
  // User acount creation successful. Redirect to login page
  ?>
  <script type = "text/javascript">
    window.location.pathname = '/Login.php';
    alert("Account created. Welcome to Eagle Events!");
  </script>

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
    <a href="#" class="logo">
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
      <h1>
        Welcome to Eagle Events! Please sign up below.
        <small>Get notified about Emory events!</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="container">
     <h3>

     </h5>
        <form name = "signupForm" action = "SignUp.php" onsubmit = "return validateForm()" method = "POST">
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="username">Username</label>
              <input type="text" name = "username" class="form-control" placeholder="Username" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="password">Password</label>
              <input type="PASSWORD" name = "password" class="form-control" placeholder="Password" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="password">Re-enter Password</label>
              <input type="PASSWORD" name = "password2" class="form-control" placeholder="Password" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="email">Email</label>
              <input type="text" name = "email" class="form-control" placeholder="Email" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="fname">First Name</label>
              <input type="text" name = "fname" class="form-control" placeholder="First Name" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="lname">Last Name</label>
              <input type="text" name = "lname" class="form-control" placeholder="Last Name" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
              <label class="custom-control-label" for="year">Year</label><br>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="Freshman" name="year" value = "Freshman" required>
                <label class="custom-control-label" for="Freshman">Freshman</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="Sophomore" name="year" value = "Sophomore" required>
                <label class="custom-control-label" for="Sophomore">Sophomore</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="Junior" name="year" value = "Junior" required>
                <label class="custom-control-label" for="Junior">Junior</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="Senior" name="year" value = "Senior" required>
                <label class="custom-control-label" for="Senior">Senior</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="Graduate" name="year" value = "Graduate" required>
                <label class="custom-control-label" for="Graduate">Graduate</label>
              </div>
          <br><br>
          <button type = "submit" class = "btn btn-primary"> Submit </button>
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
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">EagleEvents</a>.</strong> All rights reserved.
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
<!-- Form validation -->
<script>
  function validateForm(){
    // Setup regular expressions
    var letters = /[A-Z]+[a-z]+/;
    var specChar = /[^a-zA-Z0-9]/;
    var num = /\d+/;
    var email = /emory.edu/;

    // Check if username is filled out or if it already exists
    if(document.forms["signupForm"]["username"].value.length < 6){
      alert("Username must be at least 6 characters long");
      return false;
    }
    else if(document.forms["signupForm"]["username"].value.length > 16){
      alert("Username cannot exceed 16 characters")
      return false;
    }
    else{
      var userExists = <?php
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
                          if($result['uid'] != ''){
                            echo json_encode(true);
                          }
                          else{
                            echo json_encode(false);
                          }
                       ?>;
      if(userExists){
        alert("Username is already taken");
        return false;
      }
    }

    var pw = document.forms["signupForm"]["password"].value;
    var pw2 = document.forms["signupForm"]["password2"].value;
    // Check if password meets requirements
    if(pw.length > 16){
      alert("Password cannot exceed 16 characters");
      return false;
    }
    else if(pw.length < 8){
      alert("Password must be at least 8 characters long");
      return false;
    }
    else if(!letters.test(pw)){
      alert("Password must have lowercase and uppercase letters");
      return false;
    }
    else if(!specChar.test(pw)){
      alert("Password must have at least one special character");
      return false;
    }
    else if(!num.test(pw)){
      alert("Password must have at least one number");
      return false;
    }
    else if(pw.localeCompare(pw2) != 0){
      alert("Passwords do not match");
      return false;
    }

    // Check if Emory email was used
    if(!email.test(document.forms["signupForm"]["email"].value)){
      alert("Must use an Emory email to sign up")
      return false;
    }

    // Everthing is fine, complete sign up
    return true;
  }
</script>
</body>
</html>
