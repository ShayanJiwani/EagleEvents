<?php
  $BUCKET_NAME = 'eagleevents';
  $IAM_KEY = 'AKIAIVUKL325WHLZQG6A';
  $IAM_SECRET = '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';

  //require '/vendor/autoload.php';
  require '~/aws-autoloader.php';
  use Aws\S3\S3Client;
  use Aws\S3\Exception\S3Exception;
  // Get the access code
  //change the accessCode to user's Id or some verification.
  //also this is writing on the search bar
  $accessCode = $_GET['c'];
  $accessCode = strtoupper($accessCode);
  $accessCode = trim($accessCode);
  $accessCode = addslashes($accessCode);
  $accessCode = htmlspecialchars($accessCode);

  // Connect to database
  //connect here
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

  // Verify valid user
  $result = mysqli_query($conn, "SELECT * FROM s3Files WHERE "/*code='$accessCode'
   *  replace this with the userID */"") or die("Error: Invalid request");
  if (mysqli_num_rows($result) != 1) {
    die("Error: Invalid personel");
  }
  */

  // Get path from db
  $keyPath = '';
  while($row = mysqli_fetch_array($result)) {

    $keyPath = $row['s3FilePath']; //this is the imgvariable that you need to choose
  }
  // Get file
  try {
    $s3 = S3Client::factory(
      array(
        'credentials' => array(
          'key' => $IAM_KEY,
          'secret' => $IAM_SECRET
        ),
        'version' => 'latest',
        'region'  => 'us-east-2'
      )
    );
    //
    $result = $s3->getObject(array(
      'Bucket' => $BUCKET_NAME,
      'Key'    => $keyPath
    ));
    // Display it in the browser
    header("Content-Type: {$result['ContentType']}");
    header('Content-Disposition: filename="' . basename($keyPath) . '"');
    echo $result['Body'];
  } catch (Exception $e) {
    die("Error: " . $e->getMessage());
  }
