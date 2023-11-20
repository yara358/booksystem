<!-- page to delete a publisher from the list-->
<?php
// we get the publisher id
	$pubid = $_GET['pubid'];

	require "./include/dBFunctions.inc.php";
	$conn = db_connect();// the function of connection 
	// the query to deletes 
	$query = "DELETE FROM publishers WHERE publisher_id = '$pubid'";
	$result = mysqli_query($conn, $query);
	// if we had error we will get a message 
	if(!$result){
		echo "delete data unsuccessfully " . mysqli_error($conn);
		exit;
	}
	header("Location: admin_publishers.php");
?>