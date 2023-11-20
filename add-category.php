<?php
	session_start();
// acesss only for the manager and employee 
	if((!isset($_SESSION['employees'])  && !isset($_SESSION['managers']))){
		header("Location:main.php");
  }
  // the title of the page 
	$title = "Add new category";
	// pages to get function and header from 
	require "./template/header.php";
	require "./include/dBFunctions.inc.php";
	//connection to the database 
	$conn = db_connect();
// if submit button was pressed 
	if(isset($_POST["addcategory-submit"])){

	  //giving the data in sql to name 
		  $CateID = $_POST["cid"];
		  $CategoryName = $_POST["catename"];
	  // making sure information we got was logic 
			if(!preg_match("/^[a-zA-Z]*$/",$CategoryName) && !preg_match("/^[0-9]*$/",$CateID)){
				  header("Location:../add-category.php?error=invalidcategorynamenid");
				  exit();
			  }
			 else if(!preg_match("/^[a-zA-Z]*$/",$CategoryName)){
				   header("Location:../add-category.php?error=invalidcategoryname");
				   exit();
			  }//checking if the id was used before *thats very importan that every cateory have her own id for entering the right book in the right category
			 else {
				  $sql = "SELECT cate_id FROM categories WHERE cate_id = ?";
				  $stmt = mysqli_stmt_init($conn);
	  // if the connection gone wrong 
				  if(!mysqli_stmt_prepare($stmt,$sql)){
					header("Location:../add-category.php?error= sqlerror1");
					exit();
				  }
				  else {// examinem between the category ID that the employee trying to enter and the category  id that already exists in database 
					mysqli_stmt_bind_param($stmt,"s",$CateID);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					
					//$resultData = mysqli_stmt_get_result($stmt);
					$resultCheck = mysqli_stmt_num_rows($stmt);
		  
				  
					// if the result is 1 its wrong
					if($resultCheck > 0) {
					  header("Location:../add-category.php?error= usertaken &cate_id = ".$CateID);
					  exit();
					}
				  }// countinue to here mean that  the category have id that doesn't exists in the database 
			   
				// entering the info 
					   $CategoryIDInteger = (int)$CateID;
					   $sql = "INSERT INTO categories VALUES ('" .  $CategoryIDInteger . "', '" . $CategoryName. "')";
					   $result = mysqli_query($conn,$sql);
	  
					   if(!$result){
						echo "Can't add new data " . mysqli_error($conn);
						exit();
					   }
					   else {
						header("Location: add-category.php");
					  }
			  
			  }
		 
		}
?>
<!-- the form we see in the html page -->
		<main>
		   <div class="container">
			<h2 class="text-info">Add Category</h2>
			<form action="add-category.php" method="post"> 
			  <label for="cid" class="text-white font-weight-bold">Category ID:</label> 
			  <input type="text" id="cid" name="cid" placeholder="Category ID" class="form-control" required><br><br>
			  <label for="catename" class="text-white font-weight-bold">Category Name:</label>
			  <input type="text" id="catename" name="catename" placeholder="Category Name" class="form-control" required><br><br>
			  <button type="submit" name="addcategory-submit" class="btn btn-info btn-sm">Add Category</button>
		   </form>
		  </div>   
	  </main>
<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>