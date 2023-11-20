<!-- this code will show all the publishers we have in the 
data and they will have how much each have books-->
<?php
	session_start();// session starting
	require_once "./include/dBFunctions.inc.php";// page to bring all the functions from it 
	$conn = db_connect();// functions connection 

	// select all publishers by name of the pub;isher
	$query = "SELECT * FROM publishers ORDER BY publisher_id";
	$result = mysqli_query($conn, $query);// connecting of the data base 
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	// making sure all the data exists and the row isn't empty
	if(mysqli_num_rows($result) == 0){
		echo "Empty publisher ! Something wrong! check again";
		exit;
	}
// the title
	$title = "List Of Publishers";
	require "./template/header.php";// page the header
?>
<!--  the page title that will show -->
	<p class="lead">List of Publisher</p>
	<ul>
	<?php 
	// counting how much publisher have books inside the database
		while($row = mysqli_fetch_assoc($result)){
			$count = 0; 
			$query = "SELECT publisher_id FROM books";
			$result2 = mysqli_query($conn, $query);
			if(!$result2){
				echo "Can't retrieve data " . mysqli_error($conn);
				exit;
			}
			while ($pubInBook = mysqli_fetch_assoc($result2)){
				if($pubInBook['publisher_id'] == $row['publisher_id']){
					$count++;
				}
			}
	?>
		<li><!--the customer can enter the page that have full books wanted of every publisher -->
			<span class="badge"><?php echo $count; ?></span>
		    <a href="bookPerPub.php?pubid=<?php echo $row['publisher_id']; ?>"><?php echo $row['publisher_name']; ?></a>
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