<!-- This page to give the employee and the manager all the list of the books 
and also to the manager a chance to edit -->
<?php
// starting the session
	session_start();

	// the title of the page 
	$title = "List book";
	// to reqiure pages header and function 
	require_once "./template/header.php";
	require "./include/dBFunctions.inc.php";
	$conn = db_connect();
	// the function we will use is getAll to get all the books
	$result = getAll($conn);
?>	
	<div><!-- links to enter to another page or existes -->
	<a href="admin_signout.php" class="btn btn-danger"><span class="glyphicon glyphicon-off"></span>&nbsp;Logout</a>
	<a href="admin_publishers.php" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;Publishers</a>
	<a href="admin_categories.php" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Categories</a>
	<?php
	// if the manager is the admin , he can add a new book  
	if (isset($_SESSION['managers']) && $_SESSION['managers']==true){
		echo '<a class="btn btn-primary" href="add_book.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Book</a>';
	}
	?>
	</div>
	<!-- The table that we will bring from the databese -->
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
		</tr><!-- loop for bringing all the data -->
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
		<tr><!-- the rows in the database -->
			<td><?php echo $row['PID']; ?></td>
			<td><?php echo $row['Title']; ?></td>
			<td><?php echo $row['Author_name']; ?></td>
			<td><?php echo $row['Image_path']; ?></td>
			<td><?php echo $row['descriptions']; ?></td>
			<td><?php echo $row['Price']; ?></td>
			<td><?php echo getPubName($conn, $row['publisher_id']); ?></td>
			<td><?php echo getCatName($conn, $row['Category']); ?></td>
			<?php // every manager can edit or delete a book from the list 
				if(isset($_SESSION['managers']) && $_SESSION['managers']==true){
					echo '<td><a href="admin_edit.php?PID=';
					echo $row['PID'];
					echo'"><span class="glyphicon glyphicon-pencil"></span>Edit</a></td>';
				}else if (isset($_SESSION['managers']) && $_SESSION['managers']==true){
					echo '<td><a href="admin_delete.php?PID=';
					echo $row['PID']; 
					echo '"><span class="glyphicon glyphicon-trash"></span>Delete</a></td>';
				}
			?>

		</tr>
		<?php } ?>
	</table>

<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
	exit();
?>