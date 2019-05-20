<!DOCTYPE html>
<html lang="en">
<head>
  <title>PHP Kurs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <?php
  include "../config.inc.php";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
   ?>
</head>
<body>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../index.php">PHP-Tests</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="../">Home</a></li>
    </ul>
  </div>
</nav>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h2>Gallerien verwalten</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Titel</th>
          <th>Beschreibung</th>
          <th>Files</th>
          <th>Send</th>
        </tr>
      </thead>
      <tbody>
          <?php
            $sql = "SELECT * FROM `gallery`;";
            $result = $conn->query($sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $titel = $row["title"];
              $id = $row["id"];
              $desc = $row["description"];
              echo "\n<tr>\n";
              echo "<form action='../actions/update.php' method='post' enctype='multipart/form-data'>";
              echo "\n<td>\n";
              echo "<input type='text' name='name' value='$titel'>";
              echo "\n</td>\n<td>\n";
              echo "<input type='text' name='desc' value='$desc'>";
              echo "\n</td>\n<td>\n";
              echo "<input type='file' name='picture[]' multiple>";
              echo "\n</td>\n<td>\n";
              echo "<input type='hidden' name='id' value='$id'>";
              echo "<input type='submit'>";
              echo "\n</td>\n";
            }
           ?>
        </form>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <h2>Bilder verwalten</h2>
    <table class="table">
      <thead>
        <th>Vorschaubild</th>
        <th>Description</th>
        <th>Gallery</th>
        <th>Delete</th>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT * FROM `gallery_files` ORDER BY `fid_gallery`;";
          $result = $conn->query($sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $filename = $row["filename"];
            $description = $row["description"];
            $id = $row["id"];
            $galid = $row["fid_gallery"];
            $sql = "SELECT * FROM `gallery` WHERE `id` = $galid";
            $asgal = mysqli_fetch_assoc($conn->query($sql));
            echo "\n<tr>\n<td>\n";
            echo "<img class='img-thumbnail' style='max-width: 20%;' src='../galleries/gallery-$galid/$filename'>";
            echo "\n</td>\n<td>";
            echo $description;
            echo "\n</td>\n<td>";
            echo $asgal["title"];
            echo "\n</td>\n<td>";
            echo "<a href='../actions/delete_picture.php?id=$id'>Delete</a>";
            echo "\n</td>\n</tr>\n";
          }
         ?>
      </tbody>
    </table>
  </div>
</div>
</div>
</body>
</html>
