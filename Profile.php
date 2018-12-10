<?php
session_start();
$uid = $_SESSION['uid'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
if (!$uid) {
  ?>
  <script type = "text/javascript">
    window.location.pathname = '/Login.php'
  </script>
  <?php
}

$conn = mysqli_connect("localhost","root",
"Eagle123", "eagleEvents");

if (mysqli_connect_errno()){
 printf("Connect failed: %s\n", mysqli_connect_error());
 exit(1);
}

$queryUser = "SELECT CONCAT(fname,' ', lname) as Name, year as Year, email as Email
              FROM student s WHERE uid = '$uid';";

if ( ! ( $result = mysqli_query($conn, $queryUser)) ) {
 printf("Error: %s\n", mysqli_error($conn));
 exit(1);
}

$usr = "SELECT Username FROM user WHERE uid = '$uid';";

if ( ! ( $result2 = mysqli_query($conn, $usr)) ) {
 printf("Error: %s\n", mysqli_error($conn));
 exit(1);
}

$queryFollowing = "SELECT COUNT(*) AS following FROM following WHERE mainUser = '$uid';";
$queryFollowers = "SELECT COUNT(*) AS followers FROM following WHERE followingUser = '$uid';";

if ( ! ( $resultf = mysqli_query($conn, $queryFollowing)) ) {
 printf("Error: %s\n", mysqli_error($conn));
 exit(1);
}
$queryFollowing = mysqli_fetch_assoc($resultf);
$following = $queryFollowing['following'];

if ( ! ( $resultf = mysqli_query($conn, $queryFollowers)) ) {
 printf("Error: %s\n", mysqli_error($conn));
 exit(1);
}
$queryFollowers = mysqli_fetch_assoc($resultf);
$followers = $queryFollowers['followers'];

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
  <title>Eagle Events | Profile</title>
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
  <style>
    #map {
      height: 575px;
      width: 100%;
    }
    img{
      display: block;
      margin-left: auto;
      margin-right: auto;
      border-radius: 50%;
    }
    myMargin{
      margin-left: 1000px;
      margin-right: 1000px;
    }

  </style>
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
      <span class="logo-mini"><b>E</b>E</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Eagle</b>Events</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="get.php" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo ($fname . " " . $lname)?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="get.php" class="img-circle" alt="User Image">

                <p>
                  <?php echo ($fname . " " . $lname)?>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-6 text-center">
                    <a href="Followers.php"><b>Followers(<?php echo $followers ?>)</b></a>
                  </div>
                  <div class="col-xs-6 text-center">
                    <a href="Following.php"><b>Following(<?php echo $following ?>)</b></a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="Profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="Login.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="get.php" class="img-rounded" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo ($fname . " " . $lname)?></p>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href="HomePage.php"><i class="fa fa-laptop"></i> <span>Home Page</span></a></li>
        <li><a href="YourEvents.php"><i class="fa fa-table"></i> <span>Your Events</span></a></li>
        <li><a href="YourClubs.php"><i class="fa fa-table"></i> <span>Your Clubs</span></a></li>
        <li><a href="AddAnEvent.php"><i class="fa fa-edit"></i> <span>Add an Event</span></a></li>
        <li><a href="Suggestions.php"><i class="fa fa-table"></i> <span>Suggestions</span></a></li>
        <li><a href="Users.php"><i class="fa fa-users"></i> <span>Users</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-share"></i> <span>Emory University</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="AllClubs.php"><i class="fa fa-table"></i> <span>All Clubs</a></li>
            <li><a href="AllEvents.php"><i class="fa fa-table"></i> <span>All Events</a></li>
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
        <small>View Your Profile</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
          <myMargin>
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-rounded" src="get.php">
              <br>
              <div align=center>
                <?php include 'indexPic.php'; ?>
              </div>
              <br>
              <ul class="list-group list-group-unbordered">
              <?php
                while($row = mysqli_fetch_assoc($result2)) {
                  foreach ($row as $key => $value) {
                    print "<li class=\"list-group-item\">\n";
                    print "<b>" . $key . "</b> <a class=\"pull-right\">" . $value . "</a>\n";
                    print "</li>\n";
                  }
                }
                while($row = mysqli_fetch_assoc($result)) {
                  foreach ($row as $key => $value) {
                    print "<li class=\"list-group-item\">\n";
                    print "<b>" . $key . "</b> <a class=\"pull-right\">" . $value . "</a>\n";
                    print "</li>\n";
                  }
                }
              ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </myMargin>
      </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">EagleEvents</a>.</strong> All rights reserved.
  </footer>

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
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbbe_X5CHSDXRL5u2dCJrX0-p9PgBmzwA&callback=initMap">
</script>
</body>

</html>
