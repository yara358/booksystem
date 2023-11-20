<!-- Page to edit the book info -->
<?php
// session started
	session_start();
	//only the manager and employee can eneter this page 
	if(!isset($_SESSION['employees']) && !isset($_SESSION['managers'])){
		header("Location:main.php");
	}
	// the page title 
	$title = "Edit book";
	// the pages to  bring from them information
	require_once "./template/header.php";
	require "./include/dBFunctions.inc.php";
	$conn = db_connect();// funtion to bring database connection
// getting PID from the book that we need to edit 
	if(isset($_GET['PID'])){
		$book_isbn = $_GET['PID'];
	} else { // if the PID is empty
		echo "Empty query!";
		exit;
	}
// check second time to make sure that there's is PID 
	if(!isset($book_isbn)){
		echo "Empty isbn! check again!";
		exit;
	}

	// get book data
	$query = "SELECT * FROM books WHERE PID = '$book_isbn'";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	$row = mysqli_fetch_assoc($result);// enter the result to row to show the data on the page 
?>
<!-- The form to show data in html page  -->
	<form method="post" action="edit_book.php" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<th>ISBN</th>
				<td><input type="text" name="isbn" value="<?php echo $row['PID'];?>" readOnly="true"></td>
			</tr>
			<tr>
				<th>Title</th>
				<td><input type="text" name="title" value="<?php echo $row['Title'];?>" required></td>
			</tr>
			<tr>
				<th>Author</th>
				<td><input type="text" name="author" value="<?php echo $row['Author_name'];?>" required></td>
			</tr>
			<tr>
				<th>Image</th>
				<td><input type="file" name="image"><</td>
			</tr>
			<tr>
				<th>Description</th>
				<td><textarea name="descr" cols="40" rows="5"><?php echo $row['descriptions'];?></textarea>
			</tr>
			<tr>
				<th>Price</th>
				<td><input type="text" name="price" value="<?php echo $row['Price'];?>" required></td>
			</tr>
			<tr>
				<th>Publisher</th>
				<td><input type="text" name="publisher" value="<?php echo getPubName($conn, $row['publisher_id']); ?>" required></td>
			</tr>
			<tr>
				<th>Category</th>
				<td><input type="text" name="category" value="<?php echo getCatName($conn, $row['Category']); ?>" required></td>
			</tr>
		</table>
		<input type="submit" name="save_change" value="Change" class="btn btn-primary">
		<a href="admin_book.php" class="btn btn-default">Cancel</a>
	</form>
	<br/>
	<a href="admin_book.php" class="btn btn-success">Confirm</a>
<?php
	if(isset($conn)) {mysqli_close($conn);}
	require "./template/footer.php"
?>