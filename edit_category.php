<!-- This code to do update on the category information 
by update function in sql -->
<?php	
	// if save change happen
	if(!isset($_POST['save_change'])){
		echo "Something wrong!";
		exit;
	}
// entring all the information we have from the book database into variable 
	$category = trim($_POST['name']);
	$id = trim($_POST['id']);

    require_once("./include/dBFunctions.inc.php");
	$conn = db_connect();

// updating function 
	$query = "UPDATE categories SET  
	cate_name = '$category' where cate_id='$id'";
	
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't update data " . mysqli_error($conn);
		exit;
	} else {
		header("Location: admin_categories.php?bookisbn=$isbn");
	}
?>