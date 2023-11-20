<!-- the code here is to edit the category information  -->
<?php
// session started
	session_start();
//only the manager and employee can eneter this page 
	if((!isset($_SESSION['employees']) && !isset($_SESSION['managers']))){
		header("Location:main.php");
	}
	// the page title 
	$title = "Edit category";
	// the pages to  bring from them information
	require_once "./template/header.php";
	require "./include/dBFunctions.inc.php";
	$conn = db_connect();// funtion to bring database connection
// getting category id  so we can edit the category inforamtion 
	if(isset($_GET['catid'])){
		$catid = $_GET['catid'];
	} else {// if the category id  is empty
		echo "Empty query!";
		exit;
	}
// check second time to make sure that there's is ID
	if(!isset($catid)){
		echo "Empty isbn! check again!";
		exit;
	}

	// get categoroy data from the databse
	$query = "SELECT * FROM categories WHERE cate_id = '$catid'";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	$row = mysqli_fetch_assoc($result);// enter the result to row to show the data on the page 
?>
<!-- The form to show data in html page  -->
	<form method="post" action="edit_category.php" enctype="multipart/form-data">
		<table class="table">
        <th>Name</th>
			<tr>
				<td style="display:none"><input type="text" name="id" value="<?php echo $row['cate_id'];?>"></td>
				
				<td><input type="text" name="name" value="<?php echo $row['cate_name'];?>" required></td>
			</tr>

		</table>
		<input type="submit" name="save_change" value="Change" class="btn btn-primary">
		<a href="admin_categories.php" class="btn btn-default">Cancel</a>
	</form>
	<br/>
<?php
	if(isset($conn)) {mysqli_close($conn);}
	require "./template/footer.php"
?>