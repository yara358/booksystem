<!-- This code is to signup the customer -->
<?php
// session sarting
	session_start();
	// the title of the header
	$title = "User Signup";
	// the pages to take from it the functions 
	require "./template/header.php";
	require "./include/dBFunctions.inc.php";
	// function to connect the sql 
	$conn = db_connect();

		// entring the data from the form to variable 
		$firstname = trim($_POST['firstname']);
		$firstname = mysqli_real_escape_string($conn, $firstname);
		
		$lastname = trim($_POST['lastname']);
		$lastname = mysqli_real_escape_string($conn, $lastname);

		$email = trim($_POST['email']);
		$email = mysqli_real_escape_string($conn, $email);
		
		$password = trim($_POST['password']);
		$password = mysqli_real_escape_string($conn, $password);
		
		$address = trim(trim($_POST['address']));
		$address = mysqli_real_escape_string($conn, $address);
		
		$city = trim($_POST['city']);
        $city = mysqli_real_escape_string($conn, $city);
        
		$zipcode = trim($_POST['zipcode']);
		$zipcode = mysqli_real_escape_string($conn, $zipcode);

		// if any of the spaces was empty we will get a message 
		if(empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($address)||empty($city)||empty($zipcode)){
				header("Location:../signup.php?signup=empty");
		}else{
			// to validate the email 
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				header("Location:../signup.php?signup=invalidemail");
			}else{
				// making sure the customer email doesn't exsits already
				$findUser = "SELECT * FROM customers WHERE email = '$email'";
				$findResult = mysqli_query($conn, $findUser);
				if(mysqli_num_rows($findResult)==0){
					$insertUser = "INSERT INTO customers(firstname,lastname,email,address,password,city,zipcode) VALUES 
					('$firstname','$lastname','$email','$address','$password','$city','$zipcode')";
					$insertResult = mysqli_query($conn, $insertUser);
					if(!$insertResult){
						echo "Can't add new user " . mysqli_error($conn);
						exit;
				}
				$userid = mysqli_insert_id($conn);
				header("Location: signin.php");
				} else {
					$row = mysqli_fetch_assoc($findResult);
					$userid = $row['id'];
					header("Location: signin.php");
				}
			}
		}	
?>
	
<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>











