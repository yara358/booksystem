<!-- this code to be able to do search for all the books -->
<?php
// getting the text that the consumer asked for 
  $text = trim($_POST['text']);
  // page to bring the connection to database 
  require_once "./include/dBFunctions.inc.php";
  $conn = db_connect();
  // making all the wanted tables into one table to take the information from the rest of the tables 
  $query = "SELECT * FROM books join publishers on books.publisher_id=publishers.	publisher_id  where PID like'%$text%' or Author_name like '%$text%' or Title like '%$text%' or publisher_name like  '%$text%' ";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)==0){
    echo '
    <div class="alert alert-warning" role="alert">
    Nothing Found... 
    </div>' . ' <div class="search_top" >
       
 </div>';
  }else{ // showing the result 
    $number=mysqli_num_rows($result);
   echo  '<div class="alert alert-success" role="success"> ';
   echo $number;
   echo ' Books Found</div>' . ' <div class="search_top" >       
</div>';

  }
// the header
  $title = "search result";
  require "./template/header.php";
  ?>   
  <!--Printing the results  -->
  <p class="lead text-center text-muted">Search Result</p>
    <?php for($i = 0; $i < mysqli_num_rows($result); $i++){ ?>
      <div class="row">
        <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
          <div class="col-md-3">
            <a href="./book.php?PID=<?php echo $query_row['PID']; ?>">
              <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $query_row['Image_path']; ?>">
            </a>
          </div>
        <?php
          } ?> 
      </div>
<?php
      }
  if(isset($conn)) { mysqli_close($conn); }
  require_once "./template/footer.php";
?>