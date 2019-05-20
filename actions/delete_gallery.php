<?php
include "../config.inc.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

   function delTree($dir) {
     $files = array_diff(scandir($dir), array('.','..'));
      foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
      }
      return rmdir($dir);
    }

$id = $_GET["id"];
$sql = "SELECT * FROM `gallery_files` WHERE `fid_gallery` = $id;";
$result = $conn->query($sql);
$sql = "DELETE FROM `gallery` WHERE `gallery`.`id` = $id;";
$conn->query($sql);
$row = mysqli_fetch_assoc($result);
$fid = $row["fid_gallery"];
delTree("../galleries/gallery-$fid/");
header("Location: ../");
 ?>
