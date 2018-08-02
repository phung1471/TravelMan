<?php
require_once 'process.php';

/**
 * @var $travelMan \App\Classes\TravelMan
 */
?>

<!DOCTYPE html>
<html>
<head>
  <title>Travel Man</title>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php if (!empty($errMessage)) : ?>
<div class="error-notification">
  <?php echo $errMessage; ?>
</div>
<?php endif; ?>

<div class="upload-file">
  <h1> Find the shortest path</h1>
  <form method="post" action="./" enctype="multipart/form-data">
    <h3>Upload a city list:</h3>
    <div class="form-field">
      <input type="file" name="listCity"/>
    </div>
    <div class="form-field">
      <button type="submit">Upload</button>
    </div>
  </form>
</div>

<?php if (!empty($travelMan) && empty($errMessage)) : ?>
<div class="list-city">
  <h3>List City</h3>
  <p><?php echo $travelMan->getStartPoint() . ' , ' . $travelMan->getStrCityList() ?></p>
</div>

<div class="shortest-path">
  <h3>The Shortest Path</h3>
  <p>Start Point: <?php echo $travelMan->getStartPoint() ?></p>
  <p><?php echo $travelMan->getStartPoint() . $travelMan->getShortestPath()  ?></p>
</div>
<?php endif; ?>

</body>
</html>
