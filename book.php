<!-- code to show the book inforamtion according to the PID of the book-->
<?php
//seesion for the user entring the page 
  session_start();
  // getting bookisbn to show the book
  $book_isbn = $_GET['bookisbn'];
  
  // connect to database
  
  require_once "./include/dBFunctions.inc.php";
  $conn = db_connect();//database function to get the book

  // selecting all the book inforamtion by PID 
  $query = "SELECT * FROM books WHERE PID = '$book_isbn'";
  $result = mysqli_query($conn, $query);
  if(!$result){
    echo "Can't retrieve data " . mysqli_error($conn);
    exit;
  }
// entring to the row all the information to show it in the page 
  $row = mysqli_fetch_assoc($result);
  if(!$row){
    echo "Empty book";
    exit;
  }
    $title = $row['Title'];

  
?>
      <!-- Example row of columns -->
      <p class="lead" style="margin: 25px 0"><a href="books.php">Books</a> > <?php echo $row['Title']; ?></p>
      <div class="row">
        <div class="col-md-3 text-center">
          <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $row['Image_path']; ?>">
        </div>
        <div class="col-md-6">
          <h4>Book Description</h4>
          <p><?php echo $row['descriptions']; ?></p>
          <h4>Book Details</h4>
          <table class="table">
          	<?php foreach($row as $key => $value){
              if($key == "description" || $key == "Image_path" || $key == "Publisher" || $key == "Title"){
                continue;
              }
              switch($key){
                case "PID":
                  $key = "ISBN";
                  break;
                case "Title":
                  $key = "Title";
                  break;
                case "Author_name":
                  $key = "Author";
                  break;
                case "Price":
                  $key = "Price";
                  break;
              }
            ?>
            <tr>
              <td><?php echo $key; ?></td>
              <td><?php echo $value; ?></td>
            </tr>
            <?php 
              } 
              if(isset($conn)) {mysqli_close($conn); }
            ?>
          </table>
          <form method="post" action="cart.php">
            <input type="hidden" name="bookisbn" value="<?php echo $book_isbn;?>">
            
            <input type="submit" value="Add to cart" name="cart" class="btn btn-primary">
          </form>
       	</div>
      </div>
<?php
     require "./template/header.php";
     exit();

?>