<!-- This code to do update on the publisher  information 
by update function in sql -->
<?php	
	// if save change happen
	if(!isset($_POST['save_change'])){
		echo "Something wrong!";
		exit;
	}
// entring all the information we have from the book database into variable 
	$publisher = trim($_POST['name']);
	$id = trim($_POST['id']);

    require_once("./include/dBFunctions.inc.php");
	$conn = db_connect();

// updating function 
	$query = "UPDATE publishers SET  
	publisher_name = '$publisher' where publisher_id='$id'";
	
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't update data " . mysqli_error($conn);
		exit;
	} else {
		header("Location: admin_publishers.php?bookisbn=$isbn");
	}
?>