<?php
include "../config.inc.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $id = $_GET["id"];
  $sql = "SELECT * FROM `gallery_files` WHERE `id` = $id;";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  $filename = $row["filename"];
  $fid = $row["fid_gallery"];
  unlink("../galleries/gallery-$fid/$filename");
  $sql = "DELETE FROM `gallery_files` WHERE `gallery_files`.`id` = $id;";
  $conn->query($sql);
  header("Location: ../views/update_gallery.php");
 ?>
