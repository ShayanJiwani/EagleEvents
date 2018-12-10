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

   // Check is username already exists
   $queryCheckUN = "SELECT uid FROM user WHERE username = '$username'";
   $result = mysqli_query($conn, $queryCheckUN);
   $result = mysqli_fetch_assoc($result);
   if($result['uid'] != ''){ // UN exists, redirect with error message
     ?>
     <script>
        window.location.pathname = "/SignUp.php";
        alert("Username is already taken");
     </script>
     <?php
   }
   else{ // UN does not exist, create new account
    $query = "SELECT MAX(uid) AS max FROM user WHERE uid != 9999;";
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
      window.location.pathname = "/Login.php";
      alert("Account Successfully Created!")
    </script>
    <?php
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
    <p class="login-box-msg">Register for an Account</p>
    <?php
    if ($errString != "") {
      printf("<p style=\"color:red;\">". $errString ."</p>\n");
    }
    ?>
    <form name = "signupForm" action = "SignUp.php" method = "POST">
      <div class="form-group has-feedback">
        <input type="text" id = "username" name = "username" class="form-control" placeholder="Username" required
                                                                                    minlength = "6" maxlength="16">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id = "password" name = "password" class="form-control" placeholder="Password" required
                                                                                    minlength = "8" maxlength="16">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id = "password2" name = "password2" class="form-control" placeholder="Re-enter Password" required
                                                                                        minlength = "8" maxlength="16">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" id = "email" name = "email" class="form-control" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" id = "fname" name = "fname" class="form-control" placeholder="First Name" required>
        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" id = "lname" name = "lname" class="form-control" placeholder="Last Name" required>
        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
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
        <span class="glyphicon glyphicon-education form-control-feedback"></span>
      </div>

        <!-- /.col -->
        <div class="row">
          <div class="col-xs-8">
            <div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">
              Sign Up</button>
          </div>
          <!-- /.col -->
        </div>
    </form>


    <a href="Login.php" class="text-center">Already have an account?</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Form validation -->
<script>

  // Setup regular expressions
  var letters = /[A-Z]+[a-z]+/;
  var specChar = /[^a-zA-Z0-9]/;
  var num = /\d+/;
  var emailReq = /emory.edu/;
  var valid = true;
  var username = document.forms["signupForm"]["username"];

  // Check if username is filled out
  username.onchange = function(e){
    if(username.value.length < 6){
      alert("Username must be at least 6 characters long");
      valid = false;
    }
    else if(username.value.length > 16){
      alert("Username cannot exceed 16 characters");
      valid = false;
    }
    else {
      valid = true;
    }
  };

  var pw = document.forms["signupForm"]["password"];
  var pw2 = document.forms["signupForm"]["password2"];
  // Check if password meets requirements
  pw.onchange = function(e){
    if(!letters.test(pw.value)){
      alert("Password must have lowercase and uppercase letters");
      valid = false;
    }
    else if(!specChar.test(pw.value)){
      alert("Password must have at least one special character");
      valid = false;
    }
    else if(!num.test(pw.value)){
      alert("Password must have at least one number");
      valid = false;
    }
    else {
      valid = true;
    }
  };
  // Check if passwords match
  pw2.onchange = function(e){
    if(pw.value.localeCompare(pw2.value) != 0){
      alert("Passwords do not match");
      valid = false;
    }
    else {
      valid = true;
    }
  };

  // Check if Emory email was used
  var email = document.forms["signupForm"]["email"];
  email.onchange = function(e){
    if(!emailReq.test(email.value)){
      alert("Must use an Emory email to sign up");
      valid = false;
    }
    else {
      valid = true;
    }
  };
</script>
</body>
</html>
