<!-- This code to do update on the book information 
by update function in sql -->
<?php

	// if save change was send in this page 
	if(!isset($_POST['save_change'])){
		echo "Something wrong!";
		exit;
	}
// entring all the information we have from the book database into variable 
	$isbn = trim($_POST['isbn']);
	$title = trim($_POST['title']);
	$author = trim($_POST['author']);
	$descr = trim($_POST['descr']);
	$price = floatval(trim($_POST['price']));
	$publisher = trim($_POST['publisher']);
	$category = trim($_POST['category']);
// updating the image 
	if(isset($_FILES['img']) && $_FILES['img']['name'] != ""){
		$image = $_FILES['img']['name'];
		$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
		$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "images/books/";
		$uploadDirectory .= $image;
		move_uploaded_file($_FILES['img']['tmp_name'], $uploadDirectory);
	}
// asking help from the function 
	require_once("./include/dBFunctions.inc.php");
	$conn = db_connect();// function to connect the sql data

// find publisher and return pubid
		// if publisher is not in db, create new
		$findPub = "SELECT * FROM publishers WHERE publisher_name = '$publisher'";
		$findResult = mysqli_query($conn, $findPub);
		if(mysqli_num_rows($findResult)==0){
			// insert into publisher table and return id
			$insertPub = "INSERT INTO publishers(publisher_name) VALUES ('$publisher')";
			$insertResult = mysqli_query($conn, $insertPub);
			if(!$insertResult){
				echo "Can't add new publisher " . mysqli_error($conn);
				exit;
			}
			$publisherid = mysqli_insert_id($conn);
		} else {
			$row = mysqli_fetch_assoc($findResult);
			$publisherid = $row['publisher_id'];
		}
// find category and return catid
		// if category is not in db, create new
		$findCat = "SELECT * FROM categories WHERE cate_name = '$category'";
		$findResult = mysqli_query($conn, $findCat);
		if(mysqli_num_rows($findResult)==0){
			// insert into category table and return id
			$insertCat = "INSERT INTO categories(cate_name) VALUES ('$category')";
			$insertResult = mysqli_query($conn, $insertCat);
			if(!$insertResult){
				echo "Can't add new category " . mysqli_error($conn);
				exit;
			}
			$categoryid = mysqli_insert_id($conn);
		} else {
			$row = mysqli_fetch_assoc($findResult);
			$categoryid = $row['cate_id'];
		}

// updating function 
	$query = "UPDATE books SET  
	Title = '$title', 
	Author_name = '$author', 
	descriptions = '$descr', 
	Price = '$price',
	publisher_id = '$publisherid',
	Category = '$categoryid'";
	if(isset($image)){
		$query .= ", Image_path='$image' WHERE PID = '$isbn'";
	} else {
		$query .= " WHERE PID = '$isbn'";
	}
	// two cases for fie , if file submit is on => change a lot
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't update data " . mysqli_error($conn);
		exit;
	} else {
		header("Location: admin_edit.php?bookisbn=$isbn");
	}
?>