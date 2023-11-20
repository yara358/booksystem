<!-- Getting table of all the new book that were enetred to the data base-->
<?php
// the strat of the session 
	session_start();
	// the title of the book
	$title = "List book";
		//pages to get the header from it and function to connect to database 
	// and to the function etLatestEntranceForBooks
	require_once "./template/header.php";
	require "./include/dBFunctions.inc.php";
	$conn = db_connect(); // function to connect to database 
	$result = getLatestEntranceForBooks($conn); // function to show the lase book enterd to the data
?>	
<br>
<br>
	<table class="table" style="margin-top: 20px">
		<tr>
			<th>ISBN</th>
			<th>Title</th>
			<th>Author</th>
			<th>Image</th>
			<th>Description</th>
			<th>Price</th>
			<th>Publisher</th>
			<th>Category</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr><!--The loop to show the data info about the books  -->
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
		<tr>
			<td><?php echo $row['PID']; ?></td>
			<td><?php echo $row['Title']; ?></td>
			<td><?php echo $row['Author_name']; ?></td>
			<td><?php echo $row['Image_path']; ?></td>
			<td><?php echo $row['descriptions']; ?></td>
			<td><?php echo $row['Price']; ?></td>
			<td><?php echo getPubName($conn, $row['publisher_id']); ?></td>
			<td><?php echo getCatName($conn, $row['Category']); ?></td>
		</tr>
		<?php } ?>
	</table>

<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>