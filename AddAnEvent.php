<?php
// start session and store vars for later
session_start();
$uid = $_SESSION['uid'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];

// redirect to login page if person's session has ended
if (!$uid) {
  ?>
  <script type = "text/javascript">
    window.location.pathname = '/Login.php'
  </script>
  <?php
}

// connect to sql backend
$conn = mysqli_connect("localhost","root",
"Eagle123", "eagleEvents");

if (mysqli_connect_errno()){
 printf("Connect failed: %s\n", mysqli_connect_error());
 exit(1);
}

// receiving post information from AddAnEvent2
if ($_POST != NULL) {
  // create event from post data and insert into DB
  $cid = $_POST['cid'];
  $cname = $_POST['cname'];
  $ename = $_POST['ename'];
  $edescription = $_POST['edescription'];
  $edate = $_POST['edate'];
  $startTime = $_POST['startTime'];
  $endTime = $_POST['endTime'];
  $building = $_POST['building'];
  if ($_POST['room']) {
    $room = $_POST['room'];
  }
  $type = $_POST['type'];
  $getLocationId = "SELECT location_id FROM location WHERE building = '$building';";
  if ( ! ( $result = mysqli_query($conn, $getLocationId)) ) {
   printf("Error1: %s\n", mysqli_error($conn));
   exit(1);
  }
  $getLocationId = mysqli_fetch_assoc($result);
  $locID = $getLocationId['location_id'];

  $getMaxEventId = "SELECT MAX(event_id) AS max FROM event;";
  if ( ! ( $result = mysqli_query($conn, $getMaxEventId)) ) {
   printf("Error2: %s\n", mysqli_error($conn));
   exit(1);
  }
  // increase unique event ID to put in DB
  $getMaxEventId = mysqli_fetch_assoc($result);
  $maxEvent = $getMaxEventId['max'] + 1;

  // insert into event table and throw error if something comes up
  $queryInsert = "INSERT INTO event VALUES('$ename', '$edescription', '$edate', '$startTime',
                          '$endTime', '$locID', '$room', '$maxEvent', '$type',
                          1, '$uid', '$cid');";
  if ( ! ( $result = mysqli_query($conn, $queryInsert)) ) {
   printf("Error3: %s\n", mysqli_error($conn));
   exit(1);
  }
  // add the created event to the owner's list of events
  $attendanceInsert = "INSERT INTO attendance VALUES('$maxEvent','$uid');";
  if ( ! ( $result2 = mysqli_query($conn, $attendanceInsert)) ) {
    printf("Error4: %s\n", mysqli_error($conn));
    exit(1);
  }
  $successString = "Event \"" . $ename . "\" created for " . $cname;
}
else {
  $successString = "";
}
// get list of all clubs they are an owner of
$queryClubs = "SELECT c.club_id, cname AS Club FROM club c, clubMember m
          WHERE m.uid = '$uid' AND owner = 1 AND m.club_id = c.club_id
          ORDER BY cname ASC;";

if ( ! ( $result = mysqli_query($conn, $queryClubs)) ) {
 printf("Error: %s\n", mysqli_error($conn));
 exit(1);
}
// get follower/following count
$queryFollowing = "SELECT COUNT(*) AS following FROM following WHERE mainUser = '$uid';";
$queryFollowers = "SELECT COUNT(*) AS followers FROM following WHERE followingUser = '$uid';";

if ( ! ( $result2 = mysqli_query($conn, $queryFollowing)) ) {
 printf("Error: %s\n", mysqli_error($conn));
 exit(1);
}
$queryFollowing = mysqli_fetch_assoc($result2);
$following = $queryFollowing['following'];

if ( ! ( $result2 = mysqli_query($conn, $queryFollowers)) ) {
 printf("Error: %s\n", mysqli_error($conn));
 exit(1);
}
$queryFollowers = mysqli_fetch_assoc($result2);
$followers = $queryFollowers['followers'];

print "<!DOCTYPE html>\n";
print "<!--\n";
print "This is a starter template page. Use this page to start your new project from\n";
print "scratch. This page gets rid of all links and provides the needed markup only.\n";
print "-->\n";
print "<html>\n";
print "<head>\n";
print "  <meta charset=\"utf-8\">\n";
print "  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
print "  <title>Eagle Events | Add an Event</title>\n";
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
print "  <style>\n";
print "    #map {\n";
print "      height: 575px;\n";
print "      width: 100%;\n";
print "    }\n";
print "  </style>\n";
print "</head>\n";
print "<body class=\"hold-transition skin-blue sidebar-mini\">\n";
print "<div class=\"wrapper\">\n";
print "\n";
print "  <!-- Main Header -->\n";
print "  <header class=\"main-header\">\n";
print "\n";
print "    <!-- Logo -->\n";
print "    <a href=\"#\" class=\"logo\">\n";
print "      <!-- mini logo for sidebar mini 50x50 pixels -->\n";
print "      <span class=\"logo-mini\"><b>E</b>E</span>\n";
print "      <!-- logo for regular state and mobile devices -->\n";
print "      <span class=\"logo-lg\"><b>Eagle</b>Events</span>\n";
print "    </a>\n";
print "\n";
print "    <!-- Header Navbar -->\n";
print "    <nav class=\"navbar navbar-static-top\" role=\"navigation\">\n";
print "      <!-- Sidebar toggle button-->\n";
print "      <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"push-menu\" role=\"button\">\n";
print "        <span class=\"sr-only\">Toggle navigation</span>\n";
print "      </a>\n";
print "      <!-- Navbar Right Menu -->\n";
print "      <div class=\"navbar-custom-menu\">\n";
print "        <ul class=\"nav navbar-nav\">\n";
print "          <!-- User Account Menu -->\n";
print "          <li class=\"dropdown user user-menu\">\n";
print "            <!-- Menu Toggle Button -->\n";
print "            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n";
print "              <!-- The user image in the navbar-->\n";
print "              <img src=\"get.php\" class=\"user-image\" alt=\"User Image\">\n";
print "              <!-- hidden-xs hides the username on small devices so only the image appears. -->\n";
print "              <span class=\"hidden-xs\">$fname $lname</span>\n";
print "            </a>\n";
print "            <ul class=\"dropdown-menu\">\n";
print "              <!-- The user image in the menu -->\n";
print "              <li class=\"user-header\">\n";
print "                <img src=\"get.php\" class=\"img-circle\" alt=\"User Image\">\n";
print "\n";
print "                <p>$fname $lname</p>\n";
print "              </li>\n";
print "              <!-- Menu Body -->\n";
print "              <li class=\"user-body\">\n";
print "                <div class=\"row\">\n";
print "                  <div class=\"col-xs-6 text-center\">\n";
print "                    <a href=\"Followers.php\"><b>Followers($followers)</b></a>\n";
print "                  </div>\n";
print "                  <div class=\"col-xs-6 text-center\">\n";
print "                    <a href=\"Following.php\"><b>Following($following)</b></a>\n";
print "                  </div>\n";
print "                </div>\n";
print "                <!-- /.row -->\n";
print "              </li>\n";
print "              <!-- Menu Footer-->\n";
print "              <li class=\"user-footer\">\n";
print "                <div class=\"pull-left\">\n";
print "                  <a href=\"Profile.php\" class=\"btn btn-default btn-flat\">Profile</a>\n";
print "                </div>\n";
print "                <div class=\"pull-right\">\n";
print "                  <a href=\"Login.php\" class=\"btn btn-default btn-flat\">Sign out</a>\n";
print "                </div>";
print "              </li>\n";
print "            </ul>\n";
print "          </li>\n";
print "        </ul>\n";
print "      </div>\n";
print "    </nav>\n";
print "  </header>\n";
print "  <!-- Left side column. contains the logo and sidebar -->\n";
print "  <aside class=\"main-sidebar\">\n";
print "\n";
print "    <!-- sidebar: style can be found in sidebar.less -->\n";
print "    <section class=\"sidebar\">\n";
print "\n";
print "      <!-- Sidebar user panel (optional) -->\n";
print "      <div class=\"user-panel\">\n";
print "        <div class=\"pull-left image\">\n";
print "          <img src=\"get.php\" class=\"img-rounded\" alt=\"User Image\">\n";
print "        </div>\n";
print "        <div class=\"pull-left info\">\n";
print "          <p>$fname $lname</p>\n";
print "        </div>\n";
print "      </div>\n";
print "      <!-- Sidebar Menu -->\n";
print "      <ul class=\"sidebar-menu\" data-widget=\"tree\">\n";
print "        <li class=\"header\">HEADER</li>\n";
print "        <!-- Optionally, you can add icons to the links -->\n";
print "        <li><a href=\"HomePage.php\"><i class=\"fa fa-laptop\"></i> <span>Home Page</span></a></li>\n";
print "        <li><a href=\"YourEvents.php\"><i class=\"fa fa-table\"></i> <span>Your Events</span></a></li>\n";
print "        <li><a href=\"YourClubs.php\"><i class=\"fa fa-table\"></i> <span>Your Clubs</span></a></li>\n";
print "        <li class=\"active\"><a href=\"AddAnEvent.php\"><i class=\"fa fa-edit\"></i> <span>Add an Event</span></a></li>\n";
print "        <li><a href=\"Suggestions.php\"><i class=\"fa fa-table\"></i> <span>Suggestions</span></a></li>\n";
print "        <li><a href=\"Users.php\"><i class=\"fa fa-users\"></i> <span>Users</span></a></li>\n";
print "        <li class=\"treeview\">\n";
print "          <a href=\"#\"><i class=\"fa fa-share\"></i> <span>Emory University</span>\n";
print "            <span class=\"pull-right-container\">\n";
print "                <i class=\"fa fa-angle-left pull-right\"></i>\n";
print "              </span>\n";
print "          </a>\n";
print "          <ul class=\"treeview-menu\">\n";
print "            <li><a href=\"AllClubs.php\"><i class=\"fa fa-table\"></i> <span>All Clubs</a></li>\n";
print "            <li><a href=\"AllEvents.php\"><i class=\"fa fa-table\"></i> <span>All Events</a></li>\n";
print "          </ul>\n";
print "        </li>\n";
print "      </ul>\n";
print "    </section>\n";
print "  </aside>\n";
print "\n";
print "  <div class=\"content-wrapper\">\n";
print "    <section class=\"content container-fluid\">\n";
// display what event was just created
if ($successString != "") {
  printf("<p style=\"color:green;\">". $successString ."</p>\n");
}
print "          <div class=\"box box-info\">\n";
print "            <div class=\"box-header with-border\">\n";
print "              <h3 class=\"box-title\">Your Organizations</h3>\n";
print "            </div>\n";
print "            <!-- /.box-header -->\n";
print "            <div class=\"box-body\">\n";
print "              <div class=\"table-responsive\">\n";
print "                <table class=\"table no-margin\">\n";
$header = false;
print "<form action = \"AddAnEvent2.php\" method = \"POST\">";
while ($row = mysqli_fetch_assoc($result)){
  if (!$header) {
     $header = true;
     print("<thead><tr>\n");
     foreach ($row as $key => $value) {
       if ($key != 'club_id') {
         print "<th>" . $key . "</th>";
       }
     }
     print "<th>Create Event</th>";
     print("</tr></thead><tbody>\n");
  }
  print("<tr>\n");
  foreach ($row as $key => $value) {
    if ($key != 'club_id') {
      print ("<td>" . $value . "</td>");
    }
  }
  print ("<td><input type=\"radio\" name=\"cid\" value=" . $row['club_id'] . " required></td>");
  print ("</tr>\n");
}
print "                  </tbody>\n";
print "                </table>\n";
print "              </div>\n";
print "            </div>\n";
print "            <div class=\"box-footer clearfix\">\n";
print "   <input type=\"submit\" value=\"Add Event\" class=\"btn btn-sm btn-info btn-flat pull-right\">";
print "</form>\n";
print "            </div>\n";
print "          </div>\n";
print "        </div>\n";
print "    </section>\n";
print "  </div>\n";
print "  <footer class=\"main-footer\">\n";
print "    <strong>Copyright © 2018 <a href=\"#\">EagleEvents</a>.</strong> All rights reserved.\n";
print "  </footer>\n";
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
print "<script async defer\n";
print "    src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyDbbe_X5CHSDXRL5u2dCJrX0-p9PgBmzwA&callback=initMap\">\n";
print "</script>\n";
print "</body>\n";
print "\n";
print "</html>\n";

?>
