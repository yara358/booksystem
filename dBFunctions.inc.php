<?php
	if (!function_exists("db_connect")){

		function db_connect(){
			$conn = mysqli_connect("localhost", "root", "", "books_system");
			if(!$conn){
				echo "Can't connect database " . mysqli_connect_error($conn);
				exit;
			}
			return $conn;
		}
	}
	if (!function_exists("select4LatestBook")){
	function select4LatestBook($conn){
		$row = array();
		$query = "SELECT PID, Image_path FROM books ORDER BY PID DESC";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Can't retrieve data " . mysqli_error($conn);
		    exit;
		}
		for($i = 0; $i < 4; $i++){
			array_push($row, mysqli_fetch_assoc($result));
		}
		return $row;
	}
}
if (!function_exists("getBookByIsbn")){
	function getBookByIsbn($conn, $isbn){
		$query = "SELECT PID, Title, Author_name, Price  FROM books WHERE PID = '$isbn'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
		exit();
	}
}
if (!function_exists("getCartId")){
	function getCartId($conn, $customerid){
		$query = "SELECT cart_id FROM cart WHERE clent_id = '$customerid'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "retrieve data failed!" . mysqli_error($conn);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['cart_id'];
	}
}

if (!function_exists("insertIntoCart")){
	function insertIntoCart($conn, $customerid,$date){
		$query = "INSERT INTO cart(clent_id,date) VALUES('$customerid','$date') ";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Insert Cart failed " . mysqli_error($conn);
			exit;
		}
	}
}
if (!function_exists("getbookprice")){
	function getbookprice($isbn){
		$conn = db_connect();
		$query = "SELECT Price FROM books WHERE PID = '$isbn'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "get book price failed! " . mysqli_error($conn);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['Price'];
	}
}
if (!function_exists("getCustomerId")){
	function getCustomerId($username, $address, $city, $zip_code, $country){
		$conn = db_connect();
		$query = "SELECT id from customers WHERE 
		email = '$name' AND 
		address= '$address' AND 
		city = '$city' AND 
		zip_code = '$zip_code'";
		$result = mysqli_query($conn, $query);
		// if there is customer in db, take it out
		if($result){
			$row = mysqli_fetch_assoc($result);
			return $row['id'];
		} else {
			return null;
		}
	}
}
if (!function_exists("getCustomerIdbyEmail")){
	function getCustomerIdbyEmail($email){
		$conn = db_connect();
		$query = "SELECT * from customers WHERE 
		email = '$email'";
		$result = mysqli_query($conn, $query);
		// if there is customer in db, take it out
		if($result){
			$row = mysqli_fetch_assoc($result);
			return $row;
		} else {
			return null;
		}
	}
}

if (!function_exists("getPubName")){
	function getPubName($conn, $pubid){
		$query = "SELECT publisher_name FROM publishers WHERE publisher_id = '$pubid'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		if(mysqli_num_rows($result) == 0){
			echo "Not Set";
		}

		$row = mysqli_fetch_assoc($result);
		return $row['publisher_name'];
	}
}
if (!function_exists("getCatName")){
	function getCatName($conn, $catid){
		$query = "SELECT cate_name FROM categories WHERE cate_id = '$catid'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		if(mysqli_num_rows($result) == 0){
			echo "Not Set";
		}

		$row = mysqli_fetch_assoc($result);
		return $row['cate_name'];
	}
}
// function get all to bring all the books from tha database used in pages admin_book.php
if (!function_exists("getAll")){
	function getAll($conn){
		$query = "SELECT * from books ORDER BY 	PID DESC";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}
}
if (!function_exists("getAllPublishers")){
	function getAllPublishers($conn){
		$query = "SELECT * from publishers ORDER BY publisher_name ASC";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}
}
// function get all to bring all the categories from tha database used in pages admin_categories.php
if (!function_exists("getAllCategories")){
	function getAllCategories($conn){
		$query = "SELECT * from categories ORDER BY cate_name ASC";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}
}
if(!function_exists("invalidEmail")){
	function invalidEmail($email,$conn){
		$result;
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$result = true;
		}
		else {
			$result = false;
		}
		return $result;
	}
}

if(!function_exists("pwdMatch")){
	function pwdMatch($pwd,$pwdRepeat,$conn){
		$result;
		if($pwd !== $pwdRepeat){
			$result = true;
		}
		else {
			$result = false;
		}
		return $result;
	}
}

if(!function_exists("uidExsits")){
	function uidExsits($conn,$username,$email){
		$sql = "SELECT * FROM customers WHERE username = ? OR email = ?;";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location:../login.php?error=stmtfaild");
			exit();
		}

		mysqli_stmt_bind_param($stmt, "ss", $username, $email);
		mysqli_stmt_execute($stmt);

		$resultData = mysqli_stmt_get_result($stmt);

		if($row = mysqli_fetch_assoc($resultData)){
			return $row;
		}
		else {
			$result = false;
			return $result;
		}

		mysqli_stmt_close($stmt);
	}
}

if(!function_exists("uidExsitsforEnterance")){
	function uidExsitsforEnterance($conn,$phone,$email,$tablename){
		$sql = "SELECT * FROM $tablename WHERE phone = ? OR email = ?;";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location:../login.php?error=stmtfaild");
			exit();
		}

		mysqli_stmt_bind_param($stmt, "ss", $phone, $email);
		mysqli_stmt_execute($stmt);

		$resultData = mysqli_stmt_get_result($stmt);

		if($row = mysqli_fetch_assoc($resultData)){
			return $row;
		}
		else {
			$result = false;
			return $result;
		}

		mysqli_stmt_close($stmt);
	}
}

/*
if(!function_exists("SelectAuthors")){
	function SelectAuthors($conn){
		
	}
}

*/
if(!function_exists("uidExistsClients")){
	function uidExistsClients($conn,$username,$email,$result1){
		$sql = "SELECT * FROM customers WHERE username=? OR email=?;";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("location:signup.php?error=stmtfailed");
			exit();
		}

		mysqli_stmt_bind_param($stmt,"ss",$username,$email);
		mysqli_stmt_execute($stmt);

		$resultData=mysqli_stmt_get_result($stmt);

		if($row=mysqli_fetch_assoc($resultData)){
			$result1=1;
			return $row;
		}
		else {
			$result = false;
			return $result;
		}

		mysqli_stmt_close($stmt);
	}
}

if(!function_exists("uidExistsWorkers")){
	function uidExistsWorkers($conn,$ID,$email,$result2){
		$sql = "SELECT * FROM workers WHERE ID=? OR email=?;";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("location:signup.php?error=stmtfailed");
			exit();
		}

		mysqli_stmt_bind_param($stmt,"ds",$ID,$email);
		mysqli_stcartmt_execute($stmt);

		$resultData=mysqli_stmt_get_result($stmt);

		if($row=mysqli_fetch_assoc($resultData)){
			$result2=2;
			return $row;
		}
		else {
			$result = false;
			return $result;
		}

		mysqli_stmt_close($stmt);
	}
}

if(!function_exists("uidExistsEmployee")){
	function uidExistsEmployee($conn,$ID,$email,$result3){
		$sql = "SELECT * FROM employee WHERE ID=? OR email=?;";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("location:signup.php?error=stmtfailed");
			exit();
		}

		mysqli_stmt_bind_param($stmt,"ds",$ID,$email);
		mysqli_stmt_execute($stmt);

		$resultData=mysqli_stmt_get_result($stmt);

		if($row=mysqli_fetch_assoc($resultData)){
			$result3=3;
			return $row;
		}
		else {
			$result = false;
			return $result;
		}

		mysqli_stmt_close($stmt);
	}
}

if (!function_exists("select4LatestBookcate")){
	function select4LatestBookcate($conn,$cate){
		$row = array();
		$query = "SELECT PID, Image_path FROM books WHERE 	Category = '$cate'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Can't retrieve data " . mysqli_error($conn);
		    exit;
		}
		for($i = 0; $i < 4; $i++){
			array_push($row, mysqli_fetch_assoc($result));
		}
		return $row;
	}
}

if (!function_exists("sumsSales")){
	function sumsSales($qty,$isbn,$conn){

		$sum =0;
		$query = "SELECT sales FROM books WHERE PID = '$isbn'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Can't retrieve data " . mysqli_error($conn);
		    exit;
		}
		
		$row = mysqli_fetch_assoc($result); 

		$sum = $row['sales'] + $qty;

		$query = "UPDATE books SET sales ='$sum' WHERE PID ='$isbn'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Can't retrieve data " . mysqli_error($conn);
		    exit;
		}
	}
}
if (!function_exists("getBestsales")){
	function getBestsales($conn){
		$query = "SELECT * FROM books
		ORDER BY sales DESC
		LIMIT 300";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}
}

if (!function_exists("getBestAuthors")){
	function getBestAuthors($conn){
		$query = "SELECT Author_name AS most_frequent_value
		FROM books";

		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}
}


if (!function_exists("getLastSales")){
	function getLastSales($conn){
		$query = "SELECT book_id, MAX(id) from cart_items Group BY book_id";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve  data " . mysqli_error($conn);
			exit;
		}
		$rows = array();
		while($row = mysqli_fetch_array($result))
		{
			$query = "SELECT * FROM books WHERE PID = '$row[book_id]' ";
			$result1 = mysqli_query($conn, $query);

			if(!$result1){
				echo "Can't retrieve data " . mysqli_error($conn);
				exit;
			}

			return $result1;
		}
	}
}

if (!function_exists("getLatestEntranceForBooks")){
	function getLatestEntranceForBooks($conn){
		$query = "SELECT * FROM `books` ORDER BY `books`.`Date_Published` DESC
		LIMIT 15";

		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}
}

?>

