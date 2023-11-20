<!-- This code will  bring book  according to the categories that customer picked--> 
<?php
// starting the session 
	session_start();
	require_once "./include/dBFunctions.inc.php";
	// get pubid
	if(isset($_GET['catid'])){
		$catid = $_GET['catid'];
	} else {
		echo "Wrong query! Check again!";
		exit;
	}

	// connect database
	$conn = db_connect();
	$catName = getCatName($conn, $catid); // getting the category name function
// selecting the books according to the category hat  the customer picked
	$query = "SELECT PID, Title, Image_path FROM books WHERE Category = '$catid'";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	// the row of the result show 0  that mean there isn't books 
	if(mysqli_num_rows($result) == 0){
		echo "Empty books ! Please wait until new books coming!";
		exit;
	}
// the title of the page 
	$title = "Books Per Category";
	require "./template/header.php";
?><!-- The the list of the books that belong to that category that the customer wanted --> 
	<p class="lead"><a href="category_list.php">Categories</a> > <?php echo $catName; ?></p>
	<?php while($row = mysqli_fetch_assoc($result)){
?>
	<div class="row">
		<div class="col-md-3">
			<img class="img-responsive img-thumbnail" src="./images/books/<?php echo $row['Image_path'];?>">
		</div>
		<div class="col-md-7">
			<h4><?php echo $row['Title'];?></h4>
			<a href="book.php?bookisbn=<?php echo $row['PID'];?>" class="btn btn-primary">Get Details</a>
		</div>
	</div>
	<br>
<?php
	}
	if(isset($conn)) { mysqli_close($conn);}
	require "./template/footer.php";
?>