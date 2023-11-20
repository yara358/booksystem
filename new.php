<form action="indexForTheCalendar.php?action=new" method="post">
  <div class="form-group">
    <label for="start">Start date</label>
    <div class="input-group date" id="datetimepicker1">
      <input type="text" name="start" class="form-control" readonly /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
  </div>

  <div class="form-group">
    <label for="end">Finish date</label>
    <div class="input-group date" id="datetimepicker2">
      <input type="text" name="end" class="form-control" readonly /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
  </div>

  <div class="form-group">
    <label for="class">Type of events</label>
    <select class="form-control" name="class">
      <option value="event-info">Information</option>
      <option value="event-success">Completed</option>
      <option value="event-important">Important</option>
      <option value="event-warning">Warning</option>
      <option value="event-special">Special</option>
    </select>
  </div>

  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" placeholder="Enter a title" autocomplete="off" required>
  </div>

  <div class="form-group">
    <label for="body">Description</label>
    <textarea name="body" class="form-control" required></textarea>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-calendar"></span> new event</button>
  </div>
</form>