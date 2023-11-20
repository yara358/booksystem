<!-- page to delete a book from the list-->
<?php
// we get the PID of the book 
	$book_isbn = $_GET['PID'];
//  require page to give access to the database 
	require "./iٍnclude/dBFunctions.inc.php";
	$conn = db_connect(); // the function of connection 
// the query to deletes 
	$query = "DELETE FROM books WHERE PID = '$book_isbn'";
	$result = mysqli_query($conn, $query);
	// if we had error we will get a message 
	if(!$result){
		echo "delete data unsuccessfully " . mysqli_error($conn);
		exit;
	}
	header("Location: admin_book.php");
?>