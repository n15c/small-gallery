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
  include "config.inc.php";

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
      <a class="navbar-brand" href="index.php">PHP-Tests</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
    </ul>
  </div>
</nav>
<div class="jumbotron text-center">
  <div style="height: 100%; background-image: url('http://tekkie-mag.black/wp-content/uploads/2017/12/Panorama-2-1240x152.jpg'); background-repeat: no-repeat; background-size: cover; filter:blur(5px);"></div>
  <h1>Fotogalerie</h1>
  <p><small>2018 © Niels Scheunemann</small></p>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-4">
      <h2>Create Gallery</h2>
      <form class="" action="actions/create.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="title">Titel</label>
          <input class="form-control" type="text" name="title" id="title">
        </div>
        <div class="form-group">
          <label for="description">Beschreibung</label>
          <input class="form-control" type="text" name="description" id="description">
        </div>
        <div class="form-group">
          <label for="picture">Bild(er)</label>
          <input class="form-control-file" type="file" accept=".jpg" name="picture[]" id="picture" multiple>
        </div>
        <input class="form-control btn btn-primary" type="submit" name="submit" value="Upload">
      </form>
    </div>
    <div class="col-lg-8">
      <h2>Read Gallery</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Titel</th>
            <th>Beschreibung</th>
            <th>Vorschaubilder</th>
            <th>View / Update / Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = "SELECT * FROM `gallery`;";
            if ($result = $conn->query($sql)) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>\n<td>\n";
                echo $row["title"];
                echo "\n</td>\n<td>\n";
                echo $row["description"];
                echo "\n</td>\n<td>";
                $files = scandir("galleries/gallery-".$row["id"]);
                for ($i=2; $i < 5; $i++) {
                  if(count($files) > $i ){
                    $sql = "SELECT * FROM `gallery_files` WHERE `filename` LIKE '".$files[$i]."';";
                    $file = $conn->query($sql);
                    $fileinfo = mysqli_fetch_assoc($file);
                    echo "<img class='img-thumbnail' style='max-width: 20%;' src='views/thumbnail.php?id=".$fileinfo["id"]."'>";
                  }
              }
              echo "\n</td>\n<td>\n";
              echo "<a href='views/view_gallery.php?id=" . $row["id"] . "'>View</a>";
              echo "<a href='views/update_gallery.php?id=" . $row["id"] . "'> Update</a>";
              echo "<a href='actions/delete_gallery.php?id=" . $row["id"] . "'> Delete</a>";
              echo "\n</td>\n</tr>\n";
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
