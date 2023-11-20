<!-- This code will bring all best sales that happen in the website -->
<?php
// starting the session
	session_start();

	//name the title 
	$title = "best sales";
	// another pages code to bring from it the header and the function  
	require_once "./template/header.php";
	require "./include/dBFunctions.inc.php";
	$conn = db_connect();// function to connect the database
	$result = getBestsales($conn);// get best sales function
?>	
	<div><!-- linke to get out or enter to list of categories and publishers -->
	<a href="admin_signout.php" class="btn btn-danger"><span class="glyphicon glyphicon-off"></span>&nbsp;Logout</a>
	<a href="admin_publishers.php" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;Publishers</a>
	<a href="admin_categories.php" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Categories</a>
	</div>
	<!-- The table to put the best sales books in the website -->
	<table class="table" style="margin-top: 20px">
		<tr>
			<th>ISBN</th>
			<th>Title</th>
			<th>Author</th>
			<th>Image</th>
			<th>Price</th>
			<th>Publisher</th>
			<th>Category</th>
			<th>Amount of sales</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr><!--Row to show all the database results  -->
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
		<tr>
			<td><?php echo $row['PID']; ?></td>
			<td><?php echo $row['Title']; ?></td>
			<td><?php echo $row['Author_name']; ?></td>
			<td><?php echo $row['Image_path']; ?></td>
			<td><?php echo $row['Price']; ?></td>
			<td><?php echo getPubName($conn, $row['publisher_id']); ?></td>
			<td><?php echo getCatName($conn, $row['Category']); ?></td>
            <td><?php echo $row['sales']; ?></td>

		</tr>
		<?php } ?>
	</table>

<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
	exit();
?>