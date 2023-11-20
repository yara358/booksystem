<?php
	session_start();
	// acesss only for the manager and employee 
	if((!isset($_SESSION['employees']) && !isset($_SESSION['managers']))){
		header("Location:main.php");
	}
	//title of the page
	$title = "Add new publisher";
	// pages to get function and header from 
	require "./template/header.php";
	require "./include/dBFunctions.inc.php";
	//connection to the database 
	$conn = db_connect();

	// the function to do if submit button was pressed 
	if(isset($_POST["addPub-submit"])){
		require 'include/db-connect.inc.php';
	//giving the data in sql to name 
		$PublisherID = $_POST["pubId"];
		$PublisherName = $_POST["pubname"];
	  
	 // making sure information we got was logic for publisher name to have it only in latters and published Id only in numbers 
		if(!preg_match("/^[a-zA-Z ]*$/",$PublisherName) && !preg_match("/^[0-9 ]*$/",$PublisherID)){
				header("Location:../add-publisher.php?error=invaliddepartmentnamenid");
				exit();
		}
		 // making sure information we got was logic for publisher name to have it only in latters
		else if(!preg_match("/^[0-9 ]*$/",$PublisherID)){
		  header("Location:../add-publisher.php?error=invaliddepartmentid");
		  exit();
		}
		else {// makiing publish ID was not used 
		  $sql = "SELECT publisher_id FROM publishers WHERE publisher_id = ?";
		  $stmt = mysqli_stmt_init($conn);
	// if the connection gone wrong 
		  if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location:../add-publisher.php?error= sqlerror1");
			exit();
		  }
		  else {// examinem between the publisher ID that the employee trying to enter and the publisher id that already exists in database 
			mysqli_stmt_bind_param($stmt,"s",$PublisherID);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			
			//$resultData = mysqli_stmt_get_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
	
		  
			// if the result is 1 its wrong 
			if($resultCheck > 0) {
			  header("Location:../add-publisher.php?error= usertaken &deb_id = ".$PublisherID);
			  exit();
			}
		  }
	   
		// else we make the publisher id to integer and we insertt in the sql table 
			   $PublisherIDInteger = (int)$PublisherID;
			   $sql = "INSERT INTO publishers VALUES ('" .  $PublisherIDInteger . "', '" . $PublisherName. "')";
			   $result = mysqli_query($conn,$sql);
	
			   if(!$result){
				echo "Can't add new data " . mysqli_error($conn);
				exit();
			   }
			   else {
				header("Location: add-publisher.php");
			  }
	  
	  }
	
	   }
?><!-- The form to enter the publisher -->
 <main>
    <div class="container">
      <h2 class="text-info">Adding Publisher</h2>
      <form action="add-publisher.php" method="post">
        <label for="pubId" class="text-white font-weight-bold">Publisher ID:</label>
        <input type="text" id="pubId" name="pubId" placeholder="Publisher ID" class="form-control" required><br><br>
        <labe for="pubname" class="text-white font-weight-bold">Publisher Name:</labe>
        <input type="text" id="pubname" name="pubname" placeholder="Publisher Name" class="form-control" required><br><br>
        <button type="submit" name="addPub-submit" class="btn btn-info btn-sm">Add Publisher</button>
      </form> 
    </div> 
    </main>    

<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>