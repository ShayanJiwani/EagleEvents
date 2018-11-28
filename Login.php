<?php
session_start();
$_SESSION = array();
session_destroy();
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

  $queryUID = "SELECT uid FROM user WHERE username = '$username' AND password = '$password'";
  if ( ! ( $result = mysqli_query($conn, $queryUID)) ) {
   printf("Error: %s\n", mysqli_error($conn));
   exit(1);
  }
  if (mysqli_num_rows($result) == 0) {
    // write errors
    $errString = "*Username or password incorrect. Please try again.";
  }
  else {
    session_start();
    $uid = mysqli_fetch_assoc($result);
    $uid = $uid["uid"];
    $queryInfo = "SELECT fname, lname FROM student WHERE uid = '$uid'";
    if ( ! ( $result2 = mysqli_query($conn, $queryInfo)) ) {
      printf("Error: %s\n", mysqli_error($conn));
      exit(1);
    }
    $name = mysqli_fetch_assoc($result2);
    $fname = $name['fname'];
    $lname = $name['lname'];

    $_SESSION['uid'] = $uid;
    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    // add redirect here. POST array contains username + password
    ?>
    <script type = "text/javascript">
      window.location.pathname = '/HomePage.php'
    </script>
    <?php
    print("<p>user DOES exist</p>");
  }
  mysqli_close($conn);
}
print "<!DOCTYPE html>\n";
print "<!--\n";
print "This is a starter template page. Use this page to start your new project from\n";
print "scratch. This page gets rid of all links and provides the needed markup only.\n";
print "-->\n";
print "<html>\n";
print "<head>\n";
print "  <meta charset=\"utf-8\">\n";
print "  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
print "  <title>Eagle Events | Log In</title>\n";
print "  <!-- Tell the browser to be responsive to screen width -->\n";
print "  <meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\">\n";
print "  <link rel=\"stylesheet\" href=\"bower_components/bootstrap/dist/css/bootstrap.min.css\">\n";
print "  <!-- Font Awesome -->\n";
print "  <link rel=\"stylesheet\" href=\"bower_components/font-awesome/css/font-awesome.min.css\">\n";
print "  <!-- Ionicons -->\n";
print "  <link rel=\"stylesheet\" href=\"bower_components/Ionicons/css/ionicons.min.css\">\n";
print "  <!-- Theme style -->\n";
print "  <link rel=\"stylesheet\" href=\"dist/css/AdminLTE.min.css\">\n";
print "  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter\n";
print "        page. However, you can choose any other skin. Make sure you\n";
print "        apply the skin class to the body tag so the changes take effect. -->\n";
print "  <link rel=\"stylesheet\" href=\"dist/css/skins/skin-blue.min.css\">\n";
print "\n";
print "  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->\n";
print "  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->\n";
print "  <!--[if lt IE 9]>\n";
print "  <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>\n";
print "  <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>\n";
print "  <![endif]-->\n";
print "\n";
print "  <!-- Google Font -->\n";
print "  <link rel=\"stylesheet\"\n";
print "        href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic\">\n";
print "</head>\n";
print "<!--\n";
print "BODY TAG OPTIONS:\n";
print "=================\n";
print "Apply one or more of the following classes to get the\n";
print "desired effect\n";
print "|---------------------------------------------------------|\n";
print "| SKINS         | skin-blue                               |\n";
print "|               | skin-black                              |\n";
print "|               | skin-purple                             |\n";
print "|               | skin-yellow                             |\n";
print "|               | skin-red                                |\n";
print "|               | skin-green                              |\n";
print "|---------------------------------------------------------|\n";
print "|LAYOUT OPTIONS | fixed                                   |\n";
print "|               | layout-boxed                            |\n";
print "|               | layout-top-nav                          |\n";
print "|               | sidebar-collapse                        |\n";
print "|               | sidebar-mini                            |\n";
print "|---------------------------------------------------------|\n";
print "-->\n";
print "<body class=\"hold-transition skin-blue sidebar-mini\">\n";
print "<div class=\"wrapper\">\n";
print "\n";
print "  <!-- Main Header -->\n";
print "  <header class=\"main-header\">\n";
print "\n";
print "    <!-- Logo -->\n";
print "    <a href=\"index2.html\" class=\"logo\">\n";
print "      <!-- mini logo for sidebar mini 50x50 pixels -->\n";
print "      <span class=\"logo-mini\"><b>E</b>LE</span>\n";
print "      <!-- logo for regular state and mobile devices -->\n";
print "      <span class=\"logo-lg\"><b>Eagle</b>Events</span>\n";
print "    </a>\n";
print "\n";
print "    <!-- Header Navbar -->\n";
print "\n";
print "  </header>\n";
print "\n\n\n\n";
print "  <!-- Content Wrapper. Contains page content -->\n";
print "  <div class=\"content-wrapper\">\n";
print "    <!-- Content Header (Page header) -->\n";
print "    <section class=\"content-header\">\n";
print "      <h1>\n";
print "        Welcome to Eagle Events! Please enter your login information.\n";
print "      </h1>\n";
print "    </section>\n";
print "\n";
print "    <!-- Main content -->\n";
print "    <section class=\"content container-fluid\">\n";
print "\n";
print "      <!--------------------------\n";
print "        | Your Page Content Here |\n";
print "        -------------------------->\n";
print "\n";
print "        <div class=\"container\">\n";
print "     <h3>\n";
print "\n";
print "     </h5>\n";
if ($errString != "") {
  printf("<p style=\"color:red;\">". $errString ."</p>\n");
}
print "        <form action = \"Login.php\" method = \"POST\">\n";
print "          <br>\n";
print "          <div class=\"form-row\">\n";
print "            <div class=\"col\">\n";
print "              <label for=\"username\">Username</label>\n";
print "              <input type=\"text\" name = \"username\" class=\"form-control\" placeholder=\"Username\" required>\n";
print "            </div>\n";
print "          </div>\n";
print "          <br><br><br>\n";
print "          <div class=\"form-row\">\n";
print "            <div class=\"col\">\n";
print "              <label for=\"password\">Password</label>\n";
print "              <input type=\"PASSWORD\" name = \"password\" class=\"form-control\" placeholder=\"Password\" required>\n";
print "            </div>\n";
print "          </div>\n";
print "          <br><br><br>\n";
print "          <button type = \"submit\" class = \"btn btn-primary\"> Submit </button> \n";
print "        </form>\n";
print "    \n";
print "\n";
print "        <form action = \"SignUp.php\" method = \"POST\">\n";
print "            <br><br>\n";
print "            <div class=\"form-row\">\n";
print "            <div class=\"col\">\n";
print "          <button type = \"submit\" class = \"btn btn-primary\"> Sign Up for an Account </button>\n";
print "        </div>\n";
print "      </div>\n";
print "        </form>\n";
print "\n";
print "         </h5>\n";
print "   </div>\n";
print "\n";
print "    </section>\n";
print "    <!-- /.content -->\n";
print "  </div>";
print "  <!-- /.content-wrapper -->\n";
print "\n";
print "  <!-- Main Footer -->\n";
print "  <footer class=\"main-footer\">\n";
print "    <!-- Default to the left -->\n";
print "    <strong>Copyright © 2018 <a href=\"#\">EagleEvents</a>.</strong> All rights reserved.\n";
print "  </footer>\n";
print "\n\n\n\n";
print "  <!-- /.control-sidebar -->\n";
print "  <!-- Add the sidebar's background. This div must be placed\n";
print "  immediately after the control sidebar -->\n";
print "<!-- ./wrapper -->\n";
print "\n";
print "<!-- REQUIRED JS SCRIPTS -->\n";
print "\n";
print "<!-- jQuery 3 -->\n";
print "<script src=\"bower_components/jquery/dist/jquery.min.js\"></script>\n";
print "<!-- Bootstrap 3.3.7 -->\n";
print "<script src=\"bower_components/bootstrap/dist/js/bootstrap.min.js\"></script>\n";
print "<!-- AdminLTE App -->\n";
print "<script src=\"dist/js/adminlte.min.js\"></script>\n";
print "\n";
print "<!-- Optionally, you can add Slimscroll and FastClick plugins.\n";
print "     Both of these plugins are recommended to enhance the\n";
print "     user experience. -->\n";
print "</body>\n";
print "</html>";

?>
