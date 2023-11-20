<?php while ($db_file = $db_result -> fetch(PDO::FETCH_ASSOC)): ?>

<p><strong>Start date:</strong> <?php echo $db_file["start_normal"]; ?><br>
  <strong>Finish date:</strong> <?php echo $db_file["end_normal"]; ?></p>

<h3>Details:</h3>
<p><?php echo nl2br($db_file["body"]); ?></p>

<p><a href="indexForTheCalendar.php?action=remove&id=<?php echo $db_file["id"]; ?>" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-remove"></span> Remove</a></p>

<?php endwhile; ?>