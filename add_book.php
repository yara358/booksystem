<?php

	session_start();
	if((!isset($_SESSION['employees'])  && !isset($_SESSION['managers']))){
		header("Location:main.php");
  }

	$title = "Add new book";
	require "./template/header.php";
	require "./include/dBFunctions.inc.php";
	$conn = db_connect();
//when the employee submit the information 
	if(isset($_POST["addBook-submit"])){	
      
		//giving the data in sql to name 
	
		   $pid = $_POST['pid'];
		   $title = $_POST['title'];
		   $author = $_POST['auth'];
		   $publisher = $_POST['pnames'];
		   $category = $_POST['cnames'];
		   $language = $_POST['lnames'];
		   $description=$_POST['des'];
		   $price = $_POST['price'];
		   $PageNumbered = $_POST['PageNumbered'];
		   $DatePublished = $_POST['datePub'];
		   $amount = $_POST['Quantity'];
		   
			// if PID is not numbers or letters we will have message 
		   if(!preg_match("/^[a-zA-Z0-9]*$/",$pid)){
				header("Location:add_book.php?error=invalidpid");
				exit();
			}
			// if page number is not numbers  we will have message 
			else if(!preg_match("/^[0-9]*$/",$PageNumbered)){
			  header("Location:add_book.php?error=invalidNumberedPage");
			  exit();
			}
	
		   else {
			//checking pid already exsits 
		   $sql = " SELECT PID FROM books WHERE PID = ?;";
		   $stmt = mysqli_stmt_init($conn);
	
		  if(!mysqli_stmt_prepare($stmt,$sql)) {
			header("Location:../add-book.php?error= sqlerror1");
			exit();
		  }
		  else {
			  mysqli_stmt_bind_param($stmt,"s",$pid);
			  mysqli_stmt_execute($stmt);
			  mysqli_stmt_store_result($stmt);
			  
			  //$resultData = mysqli_stmt_get_result($stmt);
			  $resultCheck = mysqli_stmt_num_rows($stmt);
	
			
			  
			  if($resultCheck > 0) {
				header("Location:../add_book?error= usertaken &pid = ".$pid);
				exit();
			  }
			  else{
				$findPub = "SELECT * FROM publishers WHERE publisher_name = '$publisher'";
				$findResult = mysqli_query($conn,$findPub);
				if(mysqli_num_rows($findResult)==0){
				  //insert into publisher the publisher name and return id
				  $insertPub = "INSERT INTO publishers(publisher_name) VALUES ('$publisher')";
				  $insertResult = mysqli_query($conn, $insertPub);
				  if(!$insertResult){
					echo "Can't add new publisher" . mysqli_error($conn);
					exit();
				  }
				  $publisherid = mysqli_insert_id($conn);
				}
				else {
				  $row = mysqli_fetch_assoc($findResult);
				  $publisherid = $row['publisher_id'];
				}
				
				$findCate = "SELECT * FROM categories WHERE cate_name = '$category'";
				$findResult = mysqli_query($conn,$findCate);
				if(mysqli_num_rows($findResult)==0){
				  //insert into categories the category name and return id
				  $insertCate = "INSERT INTO categories(cate_name) VALUES ('$category')";
				  $insertResult = mysqli_query($conn, $insertCate);
				  if(!$insertResult){
					echo "Can't add new publisher" . mysqli_error($conn);
					exit();
				  }
				  $Categoryid = mysqli_insert_id($conn);
				}
				else {
				  $row = mysqli_fetch_assoc($findResult);
				  $Categoryid = $row['cate_id'];
				}
	
				$findLan = "SELECT * FROM languages WHERE language_name = '$language'";
				$findResult = mysqli_query($conn,$findLan);
				if(mysqli_num_rows($findResult)==0){
				  //insert into publisher the publisher name and return id
				  $insertLan = "INSERT INTO languages(language_name) VALUES ('$language')";
				  $insertResult = mysqli_query($conn, $insertLan);
				  if(!$insertResult){
					echo "Can't add new publisher" . mysqli_error($conn);
					exit();
				  }
				  $languageid = mysqli_insert_id($conn);
				}
				else {
				  $row = mysqli_fetch_assoc($findResult);
				  $languageid = $row['language_id'];
				}
				// bringing the photo from the file to save in the database
				if(isset($_FILES['img']) && $_FILES['img']['name'] != ""){
				  $img = $_FILES['img']['name'];
				  $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
				  $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "images/books/";
				  $uploadDirectory .= $img;
				  move_uploaded_file($_FILES['img']['tmp_name'], $uploadDirectory);
				}
				// zeroing the sales
				$sales=0;
				// making the number page that we made into integer the same with amount 
				$PageNumberedInteger = (int)$PageNumbered;
				$amountInteger = (int)$amount;
					// entering all the inforamtion binto the books data 
					$query =  "INSERT INTO books(PID,Title,Author_name,	publisher_id,Category,languages,descriptions,price,pagesNumber,Date_Published,Image_path,Quantity,sales) VALUES('$pid','$title','$author','$publisherid','$Categoryid','$languageid','$description','$price','$PageNumbered','$DatePublished','$img','$amount','$sales')";
					$result = mysqli_query($conn, $query);
					if(!$result){
						  echo "Can't add new data " . mysqli_error($conn);
						  exit;
					} else {
						  header("Location: add_book.php");
						}
	
		  header("Location:add_book.php?add_book = Success");
		  exit();
	  }
	}
	}
	
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	
	
	header("Location:add_book.php");
	exit();
	}
	
				 
				
	?>
 <!-- the form for adding a book -->
<main>
<div class="bg-image">
     <div class="container">
     <h2 class="text-info">Adding books</h2>
     <br>
      <form action="add_book.php" method="POST" enctype="multipart/form-data">
        <label for="pid" class="text-white">PID :</label> 
        <input type="text" id="pid" name="pid" placeholder="PID" class="form-control" required><br>
        <label for="title" class="text-white">Title :</label>
        <input type="text" id="title" name="title" placeholder="Title" class="form-control" required><br>
        <labe for="auth" class="text-white">Author</labe>
        <input type="text" id="auth" name="auth" placeholder="Author" class="form-control" required><br>
        <h6 class="text-white">Choose Image</h6>
        <div class="custom-file">
          <input type="file" id="img" name="img" class="custom-file-input" required>
          <label for="img" class="text-white custom-file-label">choose image</label>
        </div>
        <br>
        <label for="pnames" class="text-white"> Publisher :</label>
        <input type="text" id="pnames" name="pnames" placeholder="Publisher name" class="form-control" required><br>
        <label for="cnames" class="text-white">Category :</label>
        <input type="text" id="cnames" name="cnames" placeholder="Category name" class="form-control" required><br>
        <label for="lnames" class="text-white">Language :</label>
        <input type="text" id="lnames" name="lnames" placeholder="Language name" class="form-control" required><br>
        <label for="des" class="text-white">Description</label>
        <textarea name="des" rows= "30" cols="50" placeholder="Description" class="form-control" required></textarea><br>
        <label for="price" class="text-white"> Price </label>
        <input type="text" id="price" name="price" class="form-control" required><br><br>
        <label for="datePub" class="text-white"> Date Published </label>
        <input type="date" id="datePub" name="datePub" class="form-control" required><br><br>
        <label for="PageNumbered" class="text-white"> Page Number</label>
        <input type="text" id="PageNumbered" name="PageNumbered"  class="form-control" required><br><br>
        <label for="Quantity" class="text-white">amount</label>
        <input type="text" id="Quantity" name="Quantity" class="form-control" required><br><br>
        <button type="submit" name="addBook-submit" class="btn btn-info btn-sm">Add Book</button>
      </form> 
    </div>
  </div>    
</main> 
