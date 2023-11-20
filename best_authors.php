<!-- This code will bring all the authors name from the books table -->
<?php
//the session startes
	session_start();
	// page to bring function to connect the database
	require_once "./include/dBFunctions.inc.php";
	$conn = db_connect();// the function to conncet the  data base

	// select the author name from the  table books 
	$query = "SELECT Author_name FROM books ";
	$result = mysqli_query($conn, $query);
	if(!$result){// checking if the connection didn't work 
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}// if there nothing in the database
	if(mysqli_num_rows($result) == 0){
		echo "Empty category ! Something wrong! check again";
		exit;
	}

	// the name of the page 
	$title = "List Of Authors";
	//require the page header to add the header to page
	require "./template/header.php";
?>
<!-- The title of the page -->
	<p class="lead">List of Authors</p>
	<ul>
	<?php //the function to select all the authors names in the row
		while($row = mysqli_fetch_assoc($result)){
			$query = "SELECT Author_name FROM books ";
			$result2 = mysqli_query($conn, $query);
			if(!$result2){
				echo "Can't retrieve data " . mysqli_error($conn);
				exit;
			}
	?>
		<li><!-- Printion the author name -->
		    <p><?php echo $row['Author_name']; ?></p>
		</li>
	<?php } ?>
		<li>
			<a href="books.php">List full of books</a>
		</li>
	</ul>
<?php
	mysqli_close($conn);
	require "./template/footer.php";
?>