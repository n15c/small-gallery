<?php
  include '../inc/resize_image.inc.php';
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "picgal";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    header('Content-Type: image/png');
    $picid = $_GET["id"];
    $sql = "SELECT * FROM `gallery_files` WHERE `id` = $picid";
    $row = mysqli_fetch_assoc($conn->query($sql));
    $path = "../galleries/gallery-".$row["fid_gallery"]."/".$row["filename"];
    $img = resize_image($path, 400, 500);
    imagepng($img);
 ?>
