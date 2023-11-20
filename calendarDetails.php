<?php require "configPDO.php"; ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Twitter Bootstrap jQuery Calendar component</title>

    <meta name="description" content="Full view calendar component for twitter bootstrap with year, month, week, day views.">
    <meta name="keywords" content="jQuery,Bootstrap,Calendar,HTML,CSS,JavaScript,responsive,month,week,year,day">
    <meta name="author" content="Serhioromano">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="components/bootstrap-calendar/css/calendar.min.css">
  </head>
  <body>

    <?php if (isset($_GET["remove"]) && ($_GET["remove"]=="ok")): ?>

    <div class="alert alert-success" role="alert">
      <p><span class="glyphicon glyphicon-info-sign"></span> The event has been successfully deleted.</p>
    </div>

    <?php else:
    $db_query = "SELECT * FROM events WHERE id = :id";

    try {
      $db_result = $db_connect -> prepare($db_query);
      $db_result -> bindValue(":id", $_GET["id"]);
      $db_result -> execute();

      include "views/calendar/ver.php";

      $db_result -> CloseCursor();

    } catch(Exception $e) {
      die ('Error' . $e -> GetMessage());
      echo "<div class='alert alert-danger' role='alert'>" . $e -> getLine() . "</div>";
    } ?>

    <?php endif; ?>

  </body>
</html>

<?php $db_connect = null; ?>
