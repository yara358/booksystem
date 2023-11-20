<!-- This code to show the process after the customer sell
this will be the last page the customer will be in the purching system  -->
<?php
// starting the session 
	session_start();

	// page to bring the functions 
	require_once "./include/dBFunctions.inc.php";
	// the title 
	$title = "Purchase Process";
	require "./template/header.php";// print out header here
	// connect database
	$conn = db_connect();
// bringing the information from the database
		$username = trim($_POST['username']);
		$username = mysqli_real_escape_string($conn, $username );
	
		
		$address = trim(trim($_POST['address']));
		$address = mysqli_real_escape_string($conn, $address);
		
		$city = trim($_POST['city']);
        $city = mysqli_real_escape_string($conn, $city);
        
		$zipcode = trim($_POST['zipcode']);
		$zipcode = mysqli_real_escape_string($conn, $zipcode);

	// find customer
	$customer = getCustomerIdbyEmail($_SESSION['email']);
	$id=$customer['id'];
	$query="UPDATE customers set 
	username='$username' , address='$address', city='$city', zipcode='$zipcode'  where id='$id'
	";
	mysqli_query($conn, $query);
	$date = date("Y-m-d H:i:s");
	 //insertIntoOrder($conn, $customer['id'], $_SESSION['total_price'],$date);
	insertIntoCart($conn, $customer['id'],$date); // the function to entring the items into the cart 

	// take orderid from order to insert order items
	// $orderid = getOrderId($conn, $customer['id']);
	$Cartid = getCartId($conn, $customer['id']);

	// inserting the item into the database 
	foreach($_SESSION['cart'] as $isbn => $qty){
		$bookprice = getbookprice($isbn);
		$query = "INSERT INTO cart_items(cart_id,book_id,quanity) VALUES 
		('$Cartid', '$isbn', '$qty')";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Insert value false!" . mysqli_error($conn);
			exit;
		}
	}

	unset($_SESSION['total_price']);
	unset($_SESSION['carts']);
	unset($_SESSION['total_items']);

?>
	<p class="lead text-success" id="p">Your order has been processed sucessfully..</p>
	<?php
	$intqty=intval($qty);
		$sums = sumsSales($intqty,$isbn,$conn);
	?>
	<!--after the purching the page moves to main  -->
   <script>

		window.setTimeout(function(){

		window.location.href = "http://localhost/main.php";

		}, 3000);
	
   </script>

<?php
	if(isset($conn)){
		mysqli_close($conn);
	}
	require_once "./template/footer.php";
?>