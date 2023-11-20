<!-- The code will show all the book in database and it can also give 
the customer options in which order to show the books 
from a-z // z-a price from more expensive to least expensive 
and author a-z // z-a -->
<?php
  session_start();
  $count = 0;
  // connect database
  require_once "./include/dBFunctions.inc.php";
  $conn = db_connect();// function to connect database
  if(isset($_POST['title'])){//the customer can pick in which order the title show
    if(isset($_POST['asc'])){
      $query = "SELECT * FROM books order by Title asc";

    }
    else if(isset($_POST['desc'])){
      $query = "SELECT * FROM books order by Title desc";
    }else{
      $query = "SELECT * FROM books";
    }
  }else if(isset($_POST['price'])){//the customer can pick in which order the price least expensive or more expensive
    if(isset($_POST['asc'])){
      $query = "SELECT * FROM books order by Price asc";

    }
    else if(isset($_POST['desc'])){
      $query = "SELECT * FROM books order by Price desc";
    }else{
      $query = "SELECT * FROM books";
    }
  }else if(isset($_POST['author'])){//the customer can pick in which order the author show
    if(isset($_POST['asc'])){
      $query = "SELECT * FROM books order by Author_name asc";

    }
    else if(isset($_POST['desc'])){
      $query = "SELECT * FROM books order by Author_name desc";
    }else{
      $query = "SELECT * FROM books";
    }
  }else{
    $query = "SELECT * FROM books";
  }
// connect the data to show the result 
  $result = mysqli_query($conn, $query);
  $title = "Full Catalogs of Books";// the title of the page 
    require_once "./template/header.php";// require the header of all pages
?>
<!-- The title of the page  -->
  <p class="lead text-center text-muted">Full Catalogs of Books</p>
<h5 class="lead text-muted">Sort By:</h5><!-- The sort to show in it the books-->

<form method="post" action="books.php">
  <div class="radio">
    <label><input type="radio" name="asc" >Ascending</label>
  </div>
  <div class="radio">
    <label><input type="radio" name="desc">Descending</label>
  </div>

  <button type="submit" class="btn btn-secondary" name="title">Title</button>
  <button type="submit" class="btn btn-secondary" name="price">Price</button>
  <button type="submit" class="btn btn-secondary" name="author">Author</button>
  <button type="submit" class="btn btn-secondary" name="clear">Clear</button>
  
</form>

<br><br>
<!-- The row to show the books -->
    <?php for($i = 0; $i < mysqli_num_rows($result); $i++){ ?>
      <div class="row">
        <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
          <div class="col-md-3">
            <a href="book.php?bookisbn=<?php echo $query_row['PID']; ?>"><!-- sending to page book.php PID to show the book for the customer -->
              <img class="img-responsive img-thumbnail" src="./images/books/<?php echo $query_row['Image_path']; ?>">
              </a>
              <table>
                <tr>
                  <td><strong>  <?php echo $query_row['Title']; ?></strong></td>
                </tr>
                <tr>
                <td> <?php echo $query_row['Author_name']; ?></td>
                </tr>
                <tr>
                <td><strong>$<?php echo $query_row['Price'];?></strong>  </td>
                </tr>
              </table>
            </div>
        <?php
        // to make in one line four books not more or less
          $count++;
          if($count >= 4){
              $count = 0;
              break;
            }
          } ?> 
      </div>
      <br><br>
<?php
      }
  if(isset($conn)) { mysqli_close($conn); }
  require_once "./template/footer.php";
  exit();
?>

 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
