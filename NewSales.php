<!-- This code to show the latest sales we have 
the function getLastSales -->
<?php
// the strat of the session 
	session_start();
	// the title of the book
	$title = "List book";
	//pages to get the header from it and function to connect to database 
	// and to the function getLastSales
	require_once "./template/header.php";
	require "./include/dBFunctions.inc.php";
	$conn = db_connect();// function to connect to database
	$result = getLastSales($conn); // function to show the last sales the customer did
?>	
<br>
<br><!-- The table to show the books -->
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
			<td><?php echo getCatName($conn, $row['Category']); ?></t>

		</tr>
		<?php } ?>
	</table>

<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>