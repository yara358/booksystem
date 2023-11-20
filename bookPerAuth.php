<?php
	session_start();
	require_once "./include/dBFunctions.inc.php";
	// get pubid
	if(isset($_GET['Auth'])){
		$Author = $_GET['Auth'];
	} else {
		echo "Wrong query! Check again!";
		exit;
	}

	// connect database
	$conn = db_connect();
	$catName =  getBestAuthors($conn);

	$query = "SELECT PID, Title, Image_path FROM books WHERE Author_name = '$Author'";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}


	$title = "Books Per Author";
	require "./template/header.php";
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