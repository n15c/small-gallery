<?php
include "../config.inc.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

$sql = "SELECT * FROM `gallery_files`;";
$result = $conn->query($sql);
$same = false;
$total = count($_FILES['picture']['name']);
for($i=0; $i<$total; $i++) {
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row["filename"] == $_FILES['picture']['name'][$i]) {
        $same = true;
      }
    }
    if (!$same) {
      $pathname = "../galleries/gallery-".$_POST["id"];
      $tmpFilePath = $_FILES['picture']['tmp_name'][$i];
      if ($row["filename"] != $_FILES['picture']['name'][$i]) {
        $newFilePath = "$pathname/" . $_FILES['picture']['name'][$i];
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
          $sql = "INSERT INTO `gallery_files` (`id`, `fid_gallery`, `filename`, `description`) VALUES (NULL, '" . $_POST["id"]  . "', '" . $_FILES["picture"]["name"]["$i"]  . "', '');";
          if ($conn->query($sql) === TRUE) {
            echo "Uploaded! $i<br>";
          }
        }
      }
    }
    $same = false;
  }
  $sql = "UPDATE `gallery` SET `description` = '".$_POST["desc"]."', `title` = '".$_POST["name"]."' WHERE `gallery`.`id` = " . $_POST["id"] . ";";
  $conn->query($sql);
  header("Location: ../views/update_gallery.php");
  //var_dump($_FILES);
 ?>
