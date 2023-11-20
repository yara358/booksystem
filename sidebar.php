<!-- This code is for the sidebar in the dashboard page for the managers 
to put all the work for the manager in one place-->
<head>
  <link href="bootstrap/css/dashboard.css" type="text/css" rel="stylesheet"/>
</head>

<!-- The sidebar content-->
<div class="row">
  <div class="col-sm-1">
<div class="sidebar">
  <br>
     <a class="active" href = "main.php">Front page</a>
     <a href = "indexForTheCalendar.php">Calendar</a>
     <div class= "dropdown ">
     <button class="dropdown-btn">Activites
     <i class="fa fa-caret-down"></i>
     </button>
     <div class="dropdown-container">
      <a  href="add_book.php">add book</a>
      <a  href="accptence-newComer.php">add employee</a>
      <a  href="add-category.php">add category</a>
      <a  href="add-publisher.php">add publisher</a>
      <a  href="admin_book.php">list of books</a>
      <a  href="admin_categories.php">list of categories</a>
      <a  href="admin_editcategories.php">edit categories</a>
      <a  href="admin_editpublishers.php">edit publishers</a>
      <a  href="admin_publishers.php">list publishers</a>
      <a  href="admin_publishers.php">list publishers</a>  
      </div>
    </div> 
    <a href = "employes.list.php">Employse lists </a>
    <a href = "email.php">Email</a>
    <a href = "logout.php">logout</a>
</div>
</div>