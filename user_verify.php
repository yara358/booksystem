<!--This code is to know which one is trying to enter his account 
the manager , customer or employee -->
<?php
	session_start();
	// page to bring the function
	require_once "./include/dBFunctions.inc.php";
	$conn = db_connect();// function to connect
// entring the data from the form to variable 
	$name = trim($_POST['username']);
	$pass = trim($_POST['password']);

	// making sure the spaces full 
	if(empty($name) || empty($pass)){
		header("Location:../landofbooks/signin.php?signin=empty");
	}else{ 
		// if it eas manager 
				$query = "SELECT name,password from managers";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_assoc($result);
				 if($name == $row['name'] && $pass == $row['password'] ){
					$_SESSION['managers'] = true;
					unset($_SESSION['employees']);
					unset($_SESSION['user']);
					unset($_SESSION['email']);
					header("Location: dashboard1.php");
				}
				else{
					//check if it is employees
					$query = "SELECT name,password from employees";
					$result = mysqli_query($conn, $query);
					$row = mysqli_fetch_assoc($result);
					 if($name == $row['name'] && $pass == $row['password'] ){
						$_SESSION['employees'] = true;
						unset($_SESSION['managers']);
						unset($_SESSION['user']);
						unset($_SESSION['email']);
						header("Location: workersPage.php");
					}
				else{
						//check if it is customer
						$name = mysqli_real_escape_string($conn, $name);
						$pass = mysqli_real_escape_string($conn, $pass);

						$query = "SELECT email,password from customers";
						$result = mysqli_query($conn, $query);
						for($i = 0; $i < mysqli_num_rows($result); $i++){
							$row = mysqli_fetch_assoc($result);
							if($name == $row['email'] && $pass == $row['password'] ){ 
								$_SESSION['user'] = true;	
								$_SESSION['email'] = $name;
								unset($_SESSION['managers']);
								unset($_SESSION['employees']);
								header("Location: main.php");
							}

						}
					}
				}
			}
	

	if(isset($conn)) {mysqli_close($conn);}
	
?>