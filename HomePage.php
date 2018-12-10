<?php
// start session and store session vars for later
session_start();
$conn = mysqli_connect("localhost","root",
"Eagle123", "eagleEvents");

if (mysqli_connect_errno()){
 printf("Connect failed: %s\n", mysqli_connect_error());
 exit(1);
}

$uid = $_SESSION['uid'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
// redirect to login page if session is over
if (!$uid) {
  ?>
  <script type = "text/javascript">
    window.location.pathname = '/Login.php'
  </script>
  <?php
}
// get the events happening today, within an hour, and whose end time has not been reached
$queryEvents = "SELECT ename AS Name, edescription AS Description,
      DATE_FORMAT(e.edate, '%b %e, %Y') AS Day, TIME_FORMAT(e.startTime, '%l:%i %p') AS Starts,
      TIME_FORMAT(e.endTime, '%l:%i %p') AS Ends, l.building AS Building, e.room AS Room,c.cname AS Club,
      longitude AS Longitude, latitude AS Latitude, l.radius AS Radius, (SELECT COUNT(*)
                                                                         FROM attendance
                                                                         WHERE event_id = e.event_id) AS \"People Interested\"
      FROM attendance a, event e, location l, club c
      WHERE a.uid = '$uid' AND a.event_id = e.event_id AND l.location_id = e.location_id
      AND c.club_id = e.club_id AND e.edate >= CURDATE() AND e.endTime >= CURTIME()
      AND DATE_ADD(CURTIME(), INTERVAL 1 hour) >= e.startTime
      ORDER BY edate ASC, startTime ASC;";

if ( ! ( $resultEvent = mysqli_query($conn, $queryEvents)) ) {
  printf("Error: %s\n", mysqli_error($conn));
  exit(1);
}
// get followers/following count
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
print "<body class=\"hold-transition skin-blue sidebar-mini\">\n";
print "<div class=\"wrapper\">\n";
print "\n";
print "  <!-- Main Header -->\n";
print "  <header class=\"main-header\">\n";
print "\n";
print "    <!-- Logo -->\n";
print "    <a href=\"#\" class=\"logo\">\n";
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
print "          <!-- User Account Menu -->\n";
print "          <li class=\"dropdown user user-menu\">\n";
print "            <!-- Menu Toggle Button -->\n";
print "            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n";
print "              <!-- The user image in the navbar-->\n";
print "              <img src= \"get.php\" class=\"user-image\" alt=\"User Image\">\n";
print "              <!-- hidden-xs hides the username on small devices so only the image appears. -->\n";
print "              <span class=\"hidden-xs\">$fname $lname</span>\n";
print "            </a>\n";
print "            <ul class=\"dropdown-menu\">\n";
print "              <!-- The user image in the menu -->\n";
print "              <li class=\"user-header\">\n";
print "                <img src= \"get.php\" class=\"img-circle\" alt=\"User Image\">\n";
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
print "                </div>\n";
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
print "          <img src= \"get.php\" class=\"img-rounded\" alt=\"User Image\">\n";
print "        </div>\n";
print "        <div class=\"pull-left info\">\n";
print "          <p>$fname $lname</p>\n";
print "        </div>\n";
print "      </div>\n";
print "      <!-- Sidebar Menu -->\n";
print "      <ul class=\"sidebar-menu\" data-widget=\"tree\">\n";
print "        <li class=\"header\">HEADER</li>\n";
print "        <!-- Optionally, you can add icons to the links -->\n";
print "        <li class=\"active\"><a href=\"HomePage.php\"><i class=\"fa fa-laptop\"></i> <span>Home Page</span></a></li>\n";
print "        <li><a href=\"YourEvents.php\"><i class=\"fa fa-table\"></i> <span>Your Events</span></a></li>\n";
print "        <li><a href=\"YourClubs.php\"><i class=\"fa fa-table\"></i> <span>Your Clubs</span></a></li>\n";
print "        <li><a href=\"AddAnEvent.php\"><i class=\"fa fa-edit\"></i> <span>Add an Event</span></a></li>\n";
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
//$row = mysqli_fetch_assoc($resultEvent);
// define array of markers
$markers = array();
$count = 0;
// each object of array is a json object
while ($row = mysqli_fetch_assoc($resultEvent)) {
  //create a json object to encode and send to the map
  $jsonEvent = array();
  $jsonEvent['name'] = $row['Name'];
  $jsonEvent['description'] = $row['Description'];
  $jsonEvent['day'] = $row['Day'];
  $jsonEvent['starts'] = $row['Starts'];
  $jsonEvent['ends'] = $row['Ends'];
  $jsonEvent['building'] = $row['Building'];
  $jsonEvent['lat'] = $row['Latitude'];
  $jsonEvent['lng'] = $row['Longitude'];
  $jsonEvent['radius'] = $row['Radius'];
  $jsonEvent['room'] = $row['Room'];
  $jsonEvent['club'] = $row['Club'];
  $jsonEvent['people'] = $row['People Interested'];
  $markers[$count] = $jsonEvent;
  $count++;
}
$myJson = json_encode($markers);
?>
<!-- Main content -->
<section class="content container-fluid">
  <div id = "map"></div>
    <script>
    //exchange this part of the code to database in order to actually connect to the real data
    //just replace eventmap.
    //test data
    var markerObjects = <?php echo json_encode($markers, JSON_NUMERIC_CHECK) ?>;
    lastWindow = null
    // form map
    function initMap(){
        var options = {
          zoom:16,
          center:{lat: 33.7925,lng:-84.3240}
        };
        var map = new google.maps.Map(document.getElementById('map'),options);
        var noPoi = [{
            featureType: "poi",
            stylers: [{
                visibility: "off"
            }]
        }];

        map.setOptions({ styles: noPoi });
        // center on emory university
        var homeMarker = new google.maps.Marker({
            map: map,
            position:{lat: 33.7925,lng:-84.3240},
            title:'Emory University'
        });
        var homeInfoWindow = new google.maps.InfoWindow({
            content: homeMarker.title + "<br/>" +
                     "Welcome to your Campus Map!"
        });
        homeMarker.addListener('click', function(){
            if(lastWindow){ lastWindow.close()};
            homeInfoWindow.open(map, homeMarker);
            lastWindow = homeInfoWindow;
        });
        for (var event in markerObjects){
            addMarker(markerObjects[event]);
        }
        // random latitude and longitude calculator functions
        function getLat(event){
          var min = event.radius * -1;
          var max = event.radius;
          var delta = Math.random() * (max - min) + min + event.lat;
          return delta;
        }
        function getLng(event){
          var min = event.radius * -1;
          var max = event.radius;
          var delta = Math.random() * (max - min) + min + event.lng;
          return delta;
        }
        // add marker at a certain position w/ content from encoded json object
        function addMarker(event){
          var contentString = "Club: ".bold() + event.club +
                              "<br/>" + "Event: ".bold() + event.name + "<br/>";
            if(event.description) {
              contentString += "Event Description: ".bold() + event.description
                              + "<br/>";
            }
            contentString += "Day: ".bold() + event.day +
              "<br/>" + "Duration: ".bold() + event.starts + " - " + event.ends +
              "<br/>" + "Building: ".bold() + event.building + "<br/>";
            if (event.room) {
              contentString += "Room: ".bold() + event.room + "<br/>";
            }
            contentString += "People Interested: ".bold() + event.people;
            var marker = new google.maps.Marker({
                map: map,
                position: {lat: getLat(event),lng: getLng(event)}
            });
            if(event.name){
                var infoWindow = new google.maps.InfoWindow({
                    content: contentString
                });
                marker.addListener('click', function(){
                    if(lastWindow){ lastWindow.close()};
                    infoWindow.open(map, marker);
                    lastWindow = infoWindow;
                });
            }
        }
        // geo location that will work with HTTPS not HTTP
        var infoWindow = new google.maps.InfoWindow;
        var currentLocation = new google.maps.Marker()
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };

                //customizing the dot
                var innerMarker = new google.maps.Marker({
                    clickable: false,
                    position: pos,
                    icon:{
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: '#00BFFF',
                        fillOpacity: 0.8,
                        strokeColor:'white',
                        StrokeWeight:0,
                        strokeOpacity: 1
                    },
                    map: map
                });
                var outtermarker = new google.maps.Marker({
                    clickable: false,
                    position: pos,
                    icon:{
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 100,
                        fillColor: '#00BFFF',
                        fillOpacity: 0.3,
                        strokeColor:'blue',
                        StrokeWeight:0,
                        strokeOpacity: 0
                    },
                    map: map
                });

                map.setCenter(pos);
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }

  }
  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }
  </script>

</section>

<!-- /.content -->
</div>
<?php
print "\n";
print "  <!-- Main Footer -->\n";
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
