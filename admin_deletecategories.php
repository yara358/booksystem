<!-- page to delete a category from the list-->
<?php
// we get the category id   
	$catid = $_GET['catid'];
	/  require page to give access to the database 
	require "./include/dBFunctions.inc.php";
	$conn = db_connect();// the function of connection 
// the query to deletes 
	$query = "DELETE FROM categories WHERE cate_id = '$catid'";
	$result = mysqli_query($conn, $query);
	// if we had error we will get a message 
	if(!$result){
		echo "delete data unsuccessfully " . mysqli_error($conn);
		exit;
	}
	header("Location: admin_categories.php");
?>