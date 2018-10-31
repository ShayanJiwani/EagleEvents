<?php
/* This is the EagleEventsMainPage put into PHP*/
session_start();
$conn = mysqli_connect("localhost","root",
"Eagle123", "eagleEvents");

 if (mysqli_connect_errno()){
   printf("Connect failed: %s\n", mysqli_connect_error());
   exit(1);
 }
if ($_SESSION['uid'] != NULL) {
  $uid = $_SESSION['uid'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
}
else {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $queryUID = "SELECT uid FROM user WHERE username = '$username' AND password = '$password'";
  if ( ! ( $result = mysqli_query($conn, $queryUID)) ) {
    printf("Error: %s\n", mysqli_error($conn));
    exit(1);
  }

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
}

$_SESSION['uid'] = $uid;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;


$queryEvents = "SELECT ename AS Name, edescription AS Description,
      DATE_FORMAT(e.edate, '%b %e, %Y') AS Day, TIME_FORMAT(e.startTime, '%l:%i %p') AS Starts,
      TIME_FORMAT(e.endTime, '%l:%i %p') AS Ends, l.building AS Building, l.room AS Room,c.cname AS Club
      FROM attendance a, event e, location l, club c
      WHERE a.uid = '$uid' AND a.event_id = e.event_id AND l.location_id = e.location_id
      AND c.club_id = e.club_id ORDER BY edate ASC, startTime ASC;";

if ( ! ( $resultEvent = mysqli_query($conn, $queryEvents)) ) {
  printf("Error: %s\n", mysqli_error($conn));
  exit(1);
}
printf(" num rows == " . mysqli_num_rows($resultEvent) . " <br>");
print "<!DOCTYPE html>\n";

print "<!--\n";
print "This is a starter template page. Use this page to start your new project from\n";
print "scratch. This page gets rid of all links and provides the needed markup only.\n";
print "-->\n";
print "<html>\n";
print "<head>\n";
print "  <meta charset=\"utf-8\">\n";
print "  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
print "  <title>Eagle Events | Homepage</title>\n";
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
print "    <nav class=\"navbar navbar-static-top\" role=\"navigation\">\n";
print "      <!-- Sidebar toggle button-->\n";
print "      <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"push-menu\" role=\"button\">\n";
print "        <span class=\"sr-only\">Toggle navigation</span>\n";
print "      </a>\n";
print "      <!-- Navbar Right Menu -->\n";
print "      <div class=\"navbar-custom-menu\">\n";
print "        <ul class=\"nav navbar-nav\">\n";
print "          <!-- Messages: style can be found in dropdown.less-->\n";
print "          <li class=\"dropdown messages-menu\">\n";
print "            <!-- Menu toggle button -->\n";
print "            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n";
print "              <i class=\"fa fa-envelope-o\"></i>\n";
print "              <span class=\"label label-success\">4</span>\n";
print "            </a>\n";
print "            <ul class=\"dropdown-menu\">\n";
print "              <li class=\"header\">You have 4 evevnts</li>\n";
print "              <li>\n";
print "                <!-- inner menu: contains the messages -->\n";
print "                <ul class=\"menu\">\n";
print "                  <li><!-- start message -->\n";
print "                    <a href=\"#\">\n";
print "                      <div class=\"pull-left\">\n";
print "                        <!-- User Image -->\n";
print "                        <img src=\"Images/profile.jpeg\" class=\"img-circle\" alt=\"User Image\">\n";
print "                      </div>\n";
print "                      <!-- Message title and timestamp -->\n";
print "                      <h4>\n";
print "                        Support Team\n";
print "                        <small><i class=\"fa fa-clock-o\"></i> 5 mins</small>\n";
print "                      </h4>\n";
print "                      <!-- The message -->\n";
print "                      <p>Why not buy a new awesome theme?</p>\n";
print "                    </a>\n";
print "                  </li>\n";
print "                  <!-- end message -->\n";
print "                </ul>\n";
print "                <!-- /.menu -->\n";
print "              </li>\n";
print "              <li class=\"footer\"><a href=\"#\">See All Messages</a></li>\n";
print "            </ul>\n";
print "          </li>\n";
print "          <!-- /.messages-menu -->\n";
print "\n";
print "          <!-- Notifications Menu -->\n";
print "          <li class=\"dropdown notifications-menu\">\n";
print "            <!-- Menu toggle button -->\n";
print "            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n";
print "              <i class=\"fa fa-bell-o\"></i>\n";
print "              <span class=\"label label-warning\">10</span>\n";
print "            </a>\n";
print "            <ul class=\"dropdown-menu\">\n";
print "              <li class=\"header\">You have 10 notifications</li>\n";
print "              <li>\n";
print "                <!-- Inner Menu: contains the notifications -->\n";
print "                <ul class=\"menu\">\n";
print "                  <li><!-- start notification -->\n";
print "                    <a href=\"#\">\n";
print "                      <i class=\"fa fa-users text-aqua\"></i> 5 new members joined today\n";
print "                    </a>\n";
print "                  </li>\n";
print "                  <!-- end notification -->\n";
print "                </ul>\n";
print "              </li>\n";
print "              <li class=\"footer\"><a href=\"#\">View all</a></li>\n";
print "            </ul>\n";
print "          </li>\n";
print "          <!-- Tasks Menu -->\n";
print "          <li class=\"dropdown tasks-menu\">\n";
print "            <!-- Menu Toggle Button -->\n";
print "            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n";
print "              <i class=\"fa fa-flag-o\"></i>\n";
print "              <span class=\"label label-danger\">9</span>\n";
print "            </a>\n";
print "            <ul class=\"dropdown-menu\">\n";
print "              <li class=\"header\">You have 9 tasks</li>\n";
print "              <li>\n";
print "                <!-- Inner menu: contains the tasks -->\n";
print "                <ul class=\"menu\">\n";
print "                  <li><!-- Task item -->\n";
print "                    <a href=\"#\">\n";
print "                      <!-- Task title and progress text -->\n";
print "                      <h3>\n";
print "                        Design some buttons\n";
print "                        <small class=\"pull-right\">20%</small>\n";
print "                      </h3>\n";
print "                      <!-- The progress bar -->\n";
print "                      <div class=\"progress xs\">\n";
print "                        <!-- Change the css width attribute to simulate progress -->\n";
print "                        <div class=\"progress-bar progress-bar-aqua\" style=\"width: 20%\" role=\"progressbar\"\n";
print "                             aria-valuenow=\"20\" aria-valuemin=\"0\" aria-valuemax=\"100\">\n";
print "                          <span class=\"sr-only\">20% Complete</span>\n";
print "                        </div>\n";
print "                      </div>\n";
print "                    </a>\n";
print "                  </li>\n";
print "                  <!-- end task item -->\n";
print "                </ul>\n";
print "              </li>\n";
print "              <li class=\"footer\">\n";
print "                <a href=\"#\">View all tasks</a>\n";
print "              </li>\n";
print "            </ul>\n";
print "          </li>\n";
print "          <!-- User Account Menu -->\n";
print "          <li class=\"dropdown user user-menu\">\n";
print "            <!-- Menu Toggle Button -->\n";
print "            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n";
print "              <!-- The user image in the navbar-->\n";
print "              <img src=\"Images/profile.jpeg\" class=\"user-image\" alt=\"User Image\">\n";
print "              <!-- hidden-xs hides the username on small devices so only the image appears. -->\n";*/
/* put in user information*/
print "              <span class=\"hidden-xs\">$fname $lname</span>\n";
print "            </a>\n";
print "            <ul class=\"dropdown-menu\">\n";
print "              <!-- The user image in the menu -->\n";
print "              <li class=\"user-header\">\n";
print "                <img src=\"Images/profile.jpeg\" class=\"img-circle\" alt=\"User Image\">\n";
print "\n";
print "                <p>\n";
print "                  $fname $lname - Software Engineer\n";
print "                  <small>Member since Sep 2018</small>\n";
print "                </p>\n";
print "              </li>\n";
print "              <!-- Menu Body -->\n";
print "              <li class=\"user-body\">\n";
print "                <div class=\"row\">\n";
print "                  <div class=\"col-xs-4 text-center\">\n";
print "                    <a href=\"#\">Followers</a>\n";
print "                  </div>\n";
print "                  <div class=\"col-xs-4 text-center\">\n";
print "                    <a href=\"#\">Sales</a>\n";
print "                  </div>\n";
print "                  <div class=\"col-xs-4 text-center\">\n";
print "                    <a href=\"#\">Friends</a>\n";
print "                  </div>\n";
print "                </div>\n";
print "                <!-- /.row -->\n";
print "              </li>\n";
print "              <!-- Menu Footer-->\n";
print "              <li class=\"user-footer\">\n";
print "                <div class=\"pull-left\">\n";
print "                  <a href=\"#\" class=\"btn btn-default btn-flat\">Profile</a>\n";
print "                </div>\n";
print "                <div class=\"pull-right\">\n";
print "                  <a href=\"Login.php\" class=\"btn btn-default btn-flat\">Sign out</a>\n";
print "                </div>";
print "              </li>\n";
print "            </ul>\n";
print "          </li>\n";
print "          <!-- Control Sidebar Toggle Button -->\n";
print "          <li>\n";
print "            <a href=\"#\" data-toggle=\"control-sidebar\"><i class=\"fa fa-gears\"></i></a>\n";
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
print "          <img src=\"Images/profile.jpeg\" class=\"img-circle\" alt=\"User Image\">\n";
print "        </div>\n";
print "        <div class=\"pull-left info\">\n";
print "          <p>$fname $lname</p>\n";
print "          <!-- Status -->\n";
print "          <a href=\"#\"><i class=\"fa fa-circle text-success\"></i> Online</a>\n";
print "        </div>\n";
print "      </div>\n";
print "\n";
print "      <!-- search form (Optional) -->\n";
print "      <form action=\"#\" method=\"get\" class=\"sidebar-form\">\n";
print "        <div class=\"input-group\">\n";
print "          <input type=\"text\" name=\"q\" class=\"form-control\" placeholder=\"Search...\">\n";
print "          <span class=\"input-group-btn\">\n";
print "              <button type=\"submit\" name=\"search\" id=\"search-btn\" class=\"btn btn-flat\"><i class=\"fa fa-search\"></i>\n";
print "              </button>\n";
print "            </span>\n";
print "        </div>\n";
print "      </form>\n";
print "      <!-- /.search form -->\n";
print "\n";
print "      <!-- Sidebar Menu -->\n";
print "      <ul class=\"sidebar-menu\" data-widget=\"tree\">\n";
print "        <li class=\"header\">HEADER</li>\n";
print "        <!-- Optionally, you can add icons to the links -->\n";
print "        <li class=\"active\"><a href=\"HomePage.php\"><i class=\"fa fa-link\"></i> <span>Home Page</span></a></li>\n";
print "        <li><a href=\"YourEvents.php\"><i class=\"fa fa-link\"></i> <span>Your Events</span></a></li>\n";
print "        <li><a href=\"YourClubs.php\"><i class=\"fa fa-link\"></i> <span>Your Clubs</span></a></li>\n";
print "        <li><a href=\"AddEvent.php\"><i class=\"fa fa-link\"></i> <span>Add an Event</span></a></li>\n";
print "        <li class=\"treeview\">\n";
print "          <a href=\"#\"><i class=\"fa fa-link\"></i> <span>Emory University</span>\n";
print "            <span class=\"pull-right-container\">\n";
print "                <i class=\"fa fa-angle-left pull-right\"></i>\n";
print "              </span>\n";
print "          </a>\n";
print "          <ul class=\"treeview-menu\">\n";
print "            <li><a href=\"AllClubs.php\">All Clubs</a></li>\n";
print "            <li><a href=\"AllEvents.php\">All Events</a></li>\n";
print "          </ul>\n";
print "        </li>\n";
print "      </ul>\n";
print "      <!-- /.sidebar-menu -->\n";
print "    </section>\n";
print "    <!-- /.sidebar -->\n";
print "  </aside>\n";
print "\n";
print "  <!-- Content Wrapper. Contains page content -->\n";
print "<div class=\"content-wrapper\">\n";
print "    <!-- Content Header (Page header) -->\n";
print "    <section class=\"content-header\">\n";
print "      <h1>\n";
print "        Home\n";
print "        <small>View Events Here!</small>\n";
print "      </h1>\n";
print "    </section>\n";
print "\n";
// gets header so we can skip it
/*
$row = mysqli_fetch_assoc($resultEvent);
// define array of markers
$markers = array();
$count = 0;
// each object of array is a json object
while ($row = mysqli_fetch_assoc($resultEvent)) {
  printf($resultEvent['Name'] . "    " . $resultEvent['Description'];)
  $jsonEvent->name = $resultEvent['Name'];
  $jsonEvent->description = $resultEvent['Description'];
  $jsonEvent->day = $resultEvent['Day'];
  $jsonEvent->starts = $resultEvent['Starts'];
  $jsonEvent->ends = $resultEvent['Ends'];
  $jsonEvent->building = $resultEvent['Building'];
  $jsonEvent->room = $resultEvent['Room'];
  $jsonEvent->club = $resultEvent['Club'];
  $markers[count] = $jsonEvent;
  $count++;
}
$myJson = json_encode($markers);*/

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
print "</html>";

mysqli_close($conn);
?>
