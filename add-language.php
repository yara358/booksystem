<?php
	session_start();
// acesss only for the manager and employee 
	if((!isset($_SESSION['employees'])  && !isset($_SESSION['managers']))){
		header("Location:main.php");
  }
  // the title of the page 
	$title = "Add new language";
	// pages to get function and header from 
	require "./template/header.php";
	require "./include/dBFunctions.inc.php";
	//connection to the database 
	$conn = db_connect();
// if submit button was pressed 
	if(isset($_POST["addlanguage-submit"])){

	  //giving the data in sql to name 
		  $langID = $_POST["language_id"];
		  $languageName = $_POST["language_id"];
	  // making sure information we got was logic 
			if(!preg_match("/^[a-zA-Z]*$/",$languageName) && !preg_match("/^[0-9]*$/",$langID)){
				  header("Location:../add-language.php?error=invalidcategorynamenid");
				  exit();
			  }
			 else if(!preg_match("/^[a-zA-Z]*$/",$languageName)){
				   header("Location:../add-language.php?error=invalidcategoryname");
				   exit();
			  }//checking if the id was used before *thats very importan that every cateory have her own id for entering the right book in the right category
			 else {
				  $sql = "SELECT language_id FROM languages WHERE language_id = ?";
				  $stmt = mysqli_stmt_init($conn);
	  // if the connection gone wrong 
				  if(!mysqli_stmt_prepare($stmt,$sql)){
					header("Location:../add-language.php?error= sqlerror1");
					exit();
				  }
				  else {// examinem between the category ID that the employee trying to enter and the category  id that already exists in database 
					mysqli_stmt_bind_param($stmt,"s",$langID);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					
					//$resultData = mysqli_stmt_get_result($stmt);
					$resultCheck = mysqli_stmt_num_rows($stmt);
		  
				  
					// if the result is 1 its wrong
					if($resultCheck > 0) {
					  header("Location:../add-language.php?error= usertaken &language_id = ".$langID);
					  exit();
					}
				  }// countinue to here mean that  the category have id that doesn't exists in the database 
			   
				// entering the info 
					   $LanguageIDInteger = (int)$langID;
					   $sql = "INSERT INTO languages VALUES ('" .  $LanguageIDInteger . "', '" . $languageName. "')";
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
			<h2 class="text-info">Add language</h2>
			<form action="add-language.php" method="post"> 
			  <label for="lid" class="text-white font-weight-bold">language ID:</label> 
			  <input type="text" id="lid" name="lid" placeholder="language ID" class="form-control" required><br><br>
			  <label for="langname" class="text-white font-weight-bold">language Name:</label>
			  <input type="text" id="langname" name="langname" placeholder="language Name" class="form-control" required><br><br>
			  <button type="submit" name="addlanguage-submit" class="btn btn-info btn-sm">Add language</button>
		   </form>
		  </div>   
	  </main>
<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>