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
if ($_POST['cid']) {
  $clubID = $_POST['cid'];
  $clubName = "SELECT cname FROM club WHERE club_id = '$clubID';";
  if ( ! ( $result = mysqli_query($conn, $clubName)) ) {
   printf("Error1: %s\n", mysqli_error($conn));
   exit(1);
  }
  $clubName = mysqli_fetch_assoc($result);
  $clubName = $clubName['cname'];
  // get all event types for drop-down menu
  $queryAllEventTypes = "SELECT type FROM event GROUP BY type;";
  if ( ! ( $result = mysqli_query($conn, $queryAllEventTypes)) ) {
   printf("Error2: %s\n", mysqli_error($conn));
   exit(1);
  }

  // get all buildings for drop-down menu
  $queryAllBuildings = "SELECT building FROM location GROUP BY building;";
  if ( ! ( $result2 = mysqli_query($conn, $queryAllBuildings)) ) {
   printf("Error2: %s\n", mysqli_error($conn));
   exit(1);
  }
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
  <title>Eagle Events | Add an Event</title>
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

                <p><?php echo ($fname . " " . $lname)?></p>
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
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href="HomePage.php"><i class="fa fa-laptop"></i> <span>Home Page</span></a></li>
        <li><a href="YourEvents.php"><i class="fa fa-table"></i> <span>Your Events</span></a></li>
        <li><a href="YourClubs.php"><i class="fa fa-table"></i> <span>Your Clubs</span></a></li>
        <li class="active"><a href="AddAnEvent.php"><i class="fa fa-edit"></i> <span>Add an Event</span></a></li>
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
        Create an Event
        <small>Use the form below to post an event!</small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content container-fluid">
          <form action = "AddAnEvent.php" method = "POST" name= "search-theme-form">
          <br><br>
          <input type="hidden" id="cid" name="cid" value= "<?php echo $clubID ?>">
          <div class="form-row">
            <div class="col">
              <label for="cname">Club Name</label>
              <input type="text" name = "cname" value = "<?php echo $clubName ?>" class="form-control" readonly>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="ename">Event Name</label>
              <input type="text" name = "ename" class="form-control" placeholder="Event Name" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="edescription">Description</label>
              <input type="text" name = "edescription" class="form-control" placeholder="Description">
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="edate">Event Date</label>
              <input type="date" name = "edate" class = "form-control" placeholder="Date" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="startTime">Start Time</label>
              <input type="time" name = "startTime" class="form-control" placeholder="Starts" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="endTime">End Time</label>
              <input type="time" name = "endTime" class="form-control" placeholder="Ends" required>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="building">Building</label>
              <select name ="building" required>
                <option class ="form-control" value="" selected disabled hidden required>Select Building</option>
                <?php
                  while ($row = mysqli_fetch_assoc($result2)) {
                    foreach ($row as $key => $value) {
                      print "<option class=\"form-control\" value = \"$value\" required>$value</option>";
                    }
                  }
                ?>
              </select>
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="room">Room</label>
              <input type="text" name = "room" class="form-control" placeholder="Room">
            </div>
          </div>
          <br><br>
          <div class="form-row">
            <div class="col">
              <label for="type">Type of Event</label>
              <select name = "type" required>
                <option class ="form-control" value="" selected disabled hidden>Select Type</option>
                <?php
                  while ($row = mysqli_fetch_assoc($result)) {
                    foreach ($row as $key => $value) {
                      print "<option class=\"form-control\" value = $value required>$value</option>";
                    }
                  }
                ?>
              </select>
            </div>
          </div>
          <br><br>
          <button type = "submit" class = "btn btn-primary"> Submit </button>
        </form>
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">EagleEvents</a>.</strong> All rights reserved.
  </footer>
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
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
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbbe_X5CHSDXRL5u2dCJrX0-p9PgBmzwA&callback=initMap">
</script>
</body>

</html>
