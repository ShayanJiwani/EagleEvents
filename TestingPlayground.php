<!DOCTYPE html>
<html lang="en">
   <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     </head>
     <body>
     <!-- use the div container -->
     <div class="container">
     <h1>
        Class Statistics
     </h1>
     <P>
      <?php
      $conn = mysqli_connect("localhost","root",
      "Eagle123", "eagleEvents");

       if (mysqli_connect_errno()){
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit(1);
       }
       $uid = 1000;
       $queryEvents = "SELECT ename AS Name, edescription AS Description,
             DATE_FORMAT(e.edate, '%b %e, %Y') AS Day, TIME_FORMAT(e.startTime, '%l:%i %p') AS Starts,
             TIME_FORMAT(e.endTime, '%l:%i %p') AS Ends, l.building AS Building, l.room AS Room,c.cname AS Club
             FROM attendance a, event e, location l, club c
             WHERE a.uid = '$uid' AND a.event_id = e.event_id AND l.location_id = e.location_id
             AND c.club_id = e.club_id ORDER BY edate ASC, startTime ASC;";

       if ( ! ( $result = mysqli_query($conn, $queryEvents)) ) {
         printf("Error: %s\n", mysqli_error($conn));
         exit(1);
       }
         if ((mysqli_num_rows($result)) == 0) {
           exit("NO EVENTS FOUND");
         }

         //Creating the table for the breakdown for rate 1-10 questions
         print("<p>\n");
         print("<table class=\"table table-striped\">\n");
         # write the contents of the table
         $header = false;
         while ($row = mysqli_fetch_assoc($result)){
           if (!$header) {
              $header = true;
              # specify the header to be dark class
              print("<thead class=\"thead-dark\"><tr>\n");
              foreach ($row as $key => $value) {
                 print "<th>" . $key . "</th>";             // Print attr. name
              }
              print("</tr></thead>\n");
           }
           print("<tr>\n");     # Start row of HTML table
           foreach ($row as $key => $value) {
              print ("<td>" . $value . "</td>"); # One item in row
           }
           print ("</tr>\n");   # End row of HTML table
         }
         print("</table>\n");
         print("<p><br><br><br>\n");

         mysqli_free_result($result);
         mysqli_free_result($result2);
         mysqli_close($conn);
      ?>
      <P>
   </body>
</html>
