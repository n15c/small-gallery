<?php
include "../config.inc.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
$_POST["title"] = $conn->real_escape_string($_POST["title"]);
$_POST["description"] = $conn->real_escape_string($_POST["description"]);
$sql = "INSERT INTO `gallery` (`id`, `title`, `description`) VALUES (NULL, '" . $_POST["title"] . "', '" . $_POST["description"] . "');";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $last_id;
    $pathname = "../galleries/gallery-".$last_id;
    mkdir($pathname);
    $total = count($_FILES['picture']['name']);
    for($i=0; $i<$total; $i++) {
      $tmpFilePath = $_FILES['picture']['tmp_name'][$i];
      if ($tmpFilePath != ""){
        $newFilePath = "$pathname/" . $_FILES['picture']['name'][$i];
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
          $sql = "INSERT INTO `gallery_files` (`id`, `fid_gallery`, `filename`, `description`) VALUES (NULL, '$last_id', '" . $_FILES["picture"]["name"]["$i"]  . "', '');";
          if ($conn->query($sql) === TRUE) {
            echo "Uploaded! $i<br>";
          }
        }
  }
}
header("Location: ../");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
//var_dump($_FILES);
?>
