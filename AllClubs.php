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

 $queryClubs = "SELECT club_id, cname AS Name, cdescription AS Description, category AS Category
        FROM club WHERE club_id != 999 ORDER BY cname ASC;";

 if ( ! ( $result = mysqli_query($conn, $queryClubs)) ) {
   printf("Error: %s\n", mysqli_error($conn));
   exit(1);
 }

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
print "  <title>Eagle Events | Emory Organizations</title>\n";
print "  <!-- Tell the browser to be responsive to screen width -->\n";
print "  <meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\">\n";
print "  <link rel=\"stylesheet\" href=\"bower_components/bootstrap/dist/css/bootstrap.min.css\">\n";
print "  <!-- Font Awesome -->\n";
print "  <link rel=\"stylesheet\" href=\"bower_components/font-awesome/css/font-awesome.min.css\">\n";
print "  <!-- Ionicons -->\n";
print "  <link rel=\"stylesheet\" href=\"bower_components/Ionicons/css/ionicons.min.css\">\n";
print"   <link rel=\"stylesheet\" href=\"bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css\">\n";
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
print "        <li><a href=\"AddAnEvent.php\"><i class=\"fa fa-edit\"></i> <span>Add an Event</span></a></li>\n";
print "        <li><a href=\"Suggestions.php\"><i class=\"fa fa-table\"></i> <span>Suggestions</span></a></li>\n";
print "        <li><a href=\"Users.php\"><i class=\"fa fa-users\"></i> <span>Users</span></a></li>\n";
print "        <li class=\"treeview active\">\n";
print "          <a href=\"#\"><i class=\"fa fa-share\"></i> <span>Emory University</span>\n";
print "            <span class=\"pull-right-container\">\n";
print "                <i class=\"fa fa-angle-left pull-right\"></i>\n";
print "              </span>\n";
print "          </a>\n";
print "          <ul class=\"treeview-menu\">\n";
print "            <li class=\"active\"><a href=\"AllClubs.php\"><i class=\"fa fa-table\"></i> <span>All Clubs</a></li>\n";
print "            <li><a href=\"AllEvents.php\"><i class=\"fa fa-table\"></i> <span>All Events</a></li>\n";
print "          </ul>\n";
print "        </li>\n";
print "      </ul>\n";
print "      <!-- /.sidebar-menu -->\n";
print "    </section>\n";
print "    <!-- /.sidebar -->\n";
print "  </aside>\n";
print "\n";
print "  <!-- Content Wrapper. Contains page content -->\n";
print "  <div class=\"content-wrapper\">\n";
print "    <!-- Content Header (Page header) -->\n";
/*
print "    <section class=\"content-header\">\n";
print "      <h1>\n";
print "        Your Organizations\n";
print "        <small>Organizations you are a part of </small>\n";
print "      </h1>\n";
print "    </section>\n";
*/
print "\n";
print "    <!-- Main content -->\n";
print "    <section class=\"content container-fluid\">\n";
print "                    <!-- TABLE: LATEST ORDERS -->\n";
print "          <div class=\"box box-info\">\n";
print "            <div class=\"box-header with-border\">\n";
print "              <h3 class=\"box-title\">All Organizations</h3>\n";
print "            </div>\n";
print "            <!-- /.box-header -->\n";
print "<form action = \"YourClubs.php\" method = \"POST\">";
print "            <div class=\"box-body\">\n";
print "              <div class=\"table-responsive\">\n";
print "                <table id=\"example1\" class=\"table table-bordered table-striped\">\n";
$header = false;
$counter = 0;
while ($row = mysqli_fetch_assoc($result)){
  if (!$header) {
     $header = true;
     print("<thead><tr>\n");
     foreach ($row as $key => $value) {
       if ($key != 'club_id') {
         print "<th>" . $key . "</th>";
       }
     }
     print "<th>Checkbox</th>";
     print("</tr></thead><tbody>\n");
  }
  print("<tr>\n");
  foreach ($row as $key => $value) {
    if ($key != 'club_id') {
      print ("<td>" . $value . "</td>");
    }
  }
  print ("<td><input type=\"checkbox\" name=\"cid$counter\"  value=" . $row['club_id'] . "></td>");
  $counter++;
  print ("</tr>\n");
}
print "                  </tbody>\n";
print "                </table>\n";
print "              </div>\n";
print "              <!-- /.table-responsive -->\n";
print "            </div>\n";
print "            <!-- /.box-body -->\n";
print "            <div class=\"box-footer clearfix\">\n";
print "   <input type=\"submit\" value=\"Add Clubs\" class=\"btn btn-sm btn-default btn-flat pull-right\">";
print "</form>";
print "            <!-- /.box-footer -->\n";
print "          </div>\n";
print "          <!-- /.box -->\n";
print "        </div>\n";
print "        <!-- /.col -->";
print "    </section>\n";
print "  </div>\n";
print "  <footer class=\"main-footer\">\n";
print "    <!-- Default to the left -->\n";
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
print"<script src=\"bower_components/datatables.net/js/jquery.dataTables.min.js\"></script>\n";
print"<script src=\"bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js\"></script>\n";
print "<script src=\"bower_components/jquery-slimscroll/jquery.slimscroll.min.js\"></script>\n";
print "<script src=\"bower_components/fastclick/lib/fastclick.js\"></script>\n";
print "\n";
print "<!-- Optionally, you can add Slimscroll and FastClick plugins.\n";
print "     Both of these plugins are recommended to enhance the\n";
print "     user experience. -->\n";
print "<script async defer\n";
print "    src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyDbbe_X5CHSDXRL5u2dCJrX0-p9PgBmzwA&callback=initMap\">\n";
print "</script>\n";
?>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
