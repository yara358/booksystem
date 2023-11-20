<!-- This code is the main page of the website 
this is the first page the customer see-->
<?php
  session_start();
  $count = 0;
  // the title of the page
  $title = "Home page";
  // the pages to show the header and the function
  require_once "./template/header.php";
  require_once "./include/dBFunctions.inc.php";
  // connect database
  $conn = db_connect();
  // to select the lines of every category to show 
  $row = select4LatestBook($conn);
  $row1 = select4LatestBookcate($conn,'30');
  $row2 = select4LatestBookcate($conn,'15');
  $row3 = select4LatestBookcate($conn,'19');
  $row4 = select4LatestBookcate($conn,'27');
  $row5 = select4LatestBookcate($conn,'28');
?> 
<html>

   <body>
     <div><!-- The start of the  page -->
     <div id="top" class="container" style="margin-top: 30px;">
      <!--border--><div style="height: 40px;"></div>
      <img src="images/mainpagez.jpg" alt="image loading failure" style="width: 100%" />
      <div class="container-end" style="height: 30px;"></div>
</div> 
   </body>   
  <!-- show our latest books to enter the page according to entring fifo -->
     <br/> <br/>
      <p class="lead text-center text-muted">OUR LATEST BOOKS</p>
      <br><br>
      <div class="row">
        <?php foreach($row as $book) { ?>
      	<div class="col-md-3">
      		<a href="book.php?bookisbn=<?php echo $book['PID']; ?>">
           <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $book['Image_path']; ?>">
          </a>
      	</div>
        <?php } ?>
      </div>

      <br/> <br/><!-- The categor fashion according to the select4LatestBookcate function  -->
      <p class="lead text-center text-muted">Fashion</p>
      <br><br>
      <div class="row">
        <?php foreach($row2 as $book) { ?>
      	<div class="col-md-3">
      		<a href="book.php?bookisbn=<?php echo $book['PID']; ?>">
           <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $book['Image_path']; ?>">
          </a>
      	</div>
        <?php } ?>
      </div>

      <br/> <br/><!-- The categor poetry according to the select4LatestBookcate function  -->
      <p class="lead text-center text-muted">poetry</p>
      <br><br>
      <div class="row">
        <?php foreach($row1 as $book) { ?>
      	<div class="col-md-3">
      		<a href="book.php?bookisbn=<?php echo $book['PID']; ?>">
           <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $book['Image_path']; ?>">
          </a>
      	</div>
        <?php } ?>
      </div>

      <br/> <br/><!-- The categor classics novels according to the select4LatestBookcate function  -->
      <p class="lead text-center text-muted">Classics Novels</p>
      <br><br>
      <div class="row">
        <?php foreach($row3 as $book) { ?>
      	<div class="col-md-3">
      		<a href="book.php?bookisbn=<?php echo $book['PID']; ?>">
           <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $book['Image_path']; ?>">
          </a>
      	</div>
        <?php } ?>
      </div>

      <br/> <br/><!-- The categor Economics according to the select4LatestBookcate function  -->
      <p class="lead text-center text-muted">Economics</p>
      <br><br>
      <div class="row">
        <?php foreach($row4 as $book) { ?>
      	<div class="col-md-3">
      		<a href="book.php?bookisbn=<?php echo $book['PID']; ?>">
           <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $book['Image_path']; ?>">
          </a>
      	</div>
        <?php } ?>
      </div>

      <br/> <br/><!-- The categor kids according to the select4LatestBookcate function  -->
      <p class="lead text-center text-muted">kids</p>
      <br><br>
      <div class="row">
        <?php foreach($row5 as $book) { ?>
      	<div class="col-md-3">
      		<a href="book.php?bookisbn=<?php echo $book['PID']; ?>">
           <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $book['Image_path']; ?>">
          </a>
      	</div>
        <?php } ?>
      </div>
<?php
  if(isset($conn)) {mysqli_close($conn);}
  require_once "./template/footer.php";
?>