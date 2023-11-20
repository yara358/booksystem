<!-- This code will bring to the employee and manager all the publishers list of the book that was published and we have in the database-->
<?php
//start the session
	session_start();
	// the only peop;e have premission to enter is manager and emloyee 
	if((!isset($_SESSION['employees']) && !isset($_SESSION['managers']))){
		header("Location:main.php");
	}
	
// the name of the page 
	$title = "List publisher";
	// requiring the header and the function page to database connection and function getAllPublishers
	require_once "./template/header.php";
	require "./include/dBFunctions.inc.php";
	$conn = db_connect();// function for connection
	$result = getAllPublishers($conn);// the function to use for all the categories 
?>	
	<div><!-- links to enter to another page or existes -->
	<a href="admin_signout.php" class="btn btn-danger"><span class="glyphicon glyphicon-off"></span>&nbsp;Logout</a>
	<a href="admin_book.php" class="btn btn-primary"><span class="glyphicon glyphicon-book"></span>&nbsp;Books</a>
	<a href="admin_categories.php" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Categories</a>

	
	<a class="btn btn-primary" href="admin_add.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Book</a>

	</div>
	<!-- The table that we will bring from the databese -->
	<table class="table" style="margin-top: 20px">
		<tr>
			<th>Name</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr><!-- loop for bringing all the data -->
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
		<tr><!-- the rows in the database -->
			<td><?php echo $row['publisher_name']; ?></td>
			<?php
			// every manager can edit or delete a book from the list 
				if( isset($_SESSION['managers']) && $_SESSION['managers']==true){
					echo '<td><a href="admin_editpublishers.php?pubid=';
					echo $row['publisher_id'];
					echo'"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit</a></td>';
					echo '<td><a href="admin_deletepublishers.php?pubid=';
					echo $row['publisher_id'];
					echo '"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Delete</a></td>';
					}

			?>
		</tr>
		<?php } ?>
	</table>


	<a class="btn btn-primary" href="admin_addpublisher.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Add Publisher</a>

<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
	exit();
?>