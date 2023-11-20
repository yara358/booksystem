<!-- This code to do update on the the profile user information 
by update function in sql -->
<?php
// making sure there is session (custome loged in)
	session_start();

	// requiring page to bring all the function 
	require_once "./include/dBFunctions.inc.php";
	// print out header here
	$title = "Edit Profile"; // the title 
	require "./template/header.php";
	// connect database
	$conn = db_connect();
// connecting the database sql and entring all the information we have from the book database into variable 
		$username = trim($_POST['username ']);
		$username = mysqli_real_escape_string($conn, $username );
		
        
		$email = trim($_POST['email']);
		$email = mysqli_real_escape_string($conn, $email);
	
		
		$address = trim(trim($_POST['address']));
		$address = mysqli_real_escape_string($conn, $address);
		
		$city = trim($_POST['city']);
        $city = mysqli_real_escape_string($conn, $city);
        
		$zipcode = trim($_POST['zipcode']);
		$zipcode = mysqli_real_escape_string($conn, $zipcode);

	// updating function 
	$customer = getCustomerIdbyEmail($_SESSION['email']);
    $id=$customer['clientid'];
	$query="UPDATE clients set 
	username='$username' , address='$address', city='$city', zipcode='$zipcode' ,email='$email'  where clientid='$id'
	";
   mysqli_query($conn, $query);

    
?>

<p class="lead text-success" id="p">Your Profile has been updated sucessfully..</p>
 <!-- entering the main page after succseful update -->  
   <script>
   	
		window.setTimeout(function(){

		window.location.href = "http://localhost/landsofbookd/main.php";

		}, 3000);
	
   </script>

<?php
	if(isset($conn)){
		mysqli_close($conn);
	}
	require_once "./template/footer.php";
?>