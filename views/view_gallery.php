<!DOCTYPE html>
<html lang="en">
<head>
  <title>Fotogalerie</title>
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
      <li class="active"><a href="../index.php">Home</a></li>
    </ul>
  </div>
</nav>
<div class="container">
  <div class="row">
    <?php
      $sql = "SELECT * FROM `gallery_files` WHERE `fid_gallery` = " . $_GET["id"]  . ";";
      if ($result = $conn->query($sql)) {
        $counter = -1;
        while ($row = mysqli_fetch_assoc($result)):?>
        <?php
        $counter++;
          if (($counter % 3) == 0)
          {
            echo "</div><div class='row'>";
          }
          ?>
          <div class="col-md-4">
         <div class="thumbnail">
           <a onclick="$('#mod<?php echo $row["id"];?>').modal('show')">
             <img src="../galleries/gallery-<?php echo $row["fid_gallery"]."/".$row["filename"];?>" style="width:100%">
             <div class="caption">
               <p><?php echo $row["description"];?></p>
             </div>
           </a>
         </div>
       </div>
       <div class="modal fade" id="mod<?php echo $row["id"];?>" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <img src="../galleries/gallery-<?php echo $row["fid_gallery"]."/".$row["filename"];?>" style="width:100%">
             </div>
           </div>
         </div>
       </div>
        <?php
      endwhile;
      }
     ?>
  </div>
</div>
</body>
</html>
