<!-- This code will  bring book  according to the publisher that customer picked --> 
<?php
// starting the session
	session_start();
	require_once "./include/dBFunctions.inc.php";
	// get pubid
	if(isset($_GET['pubid'])){
		$pubid = $_GET['pubid'];
	} else {
		echo "Wrong query! Check again!";
		exit;
	}

	// connect database
	$conn = db_connect();
	$pubName = getPubName($conn, $pubid); //getting the publisher name function
// selecting the books according to the category hat  the customer picked
	$query = "SELECT PID, Title, Image_path FROM books WHERE publisher_id = '$pubid'";
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
	$title = "Books Per Publisher";
	require "./template/header.php";
?><!-- The the list of the books that belong to that category that the customer wanted --> 
	<p class="lead"><a href="publisher_list.php">Publishers</a> > <?php echo $pubName; ?></p>
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