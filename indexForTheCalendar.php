<?php require "configPDO.php";
require "./template/header.php";

$title = "Calendar"; // the title of the page 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Boostrap datepicker</title>

    <script src="components/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="components/bootstrap-calendar/css/calendar.min.css">
    <link rel="stylesheet" href="components/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
  </head>
  <body>
    <div class="container">
     
      
      <?php if (isset($_GET["action"]) && ($_GET["action"]=="new")):
      
      $event = new calendar();
      $event -> new($db_connect);?>
      
      
      <?php elseif (isset($_GET["action"]) && ($_GET["action"]=="remove")):
      $event = new calendar();
      $event -> remove($db_connect);?>

      
      <?php else: ?>
      <?php include_once "calendar.php"; ?>

      <?php endif; ?>
    </div>
  </body>
</html>


<?php $db_connect = null; 
require_once "./template/footer.php";

?>