<!-- this code will show the cart , the books the customer want to buy 
and his history of buying books -->
<?php
// session start for the customer 
	session_start();
	// bringing pages to help the code in header and function to bring data and function of the cart
	require_once "./include/dBFunctions.inc.php";
	require_once "./include/cart_functions,inc.php";
	$title = "Your shopping cart"; // the title of the page 
	require "./template/header.php";
	$conn = db_connect();// function to connect the data
	// book_isbn got from form post method, change this place later.
	if(isset($_POST['bookisbn'])){
		$book_isbn = $_POST['bookisbn'];
	}
// if the book was send it to the cart 
	if(isset($book_isbn)){
		// new item selected
		if(!isset($_SESSION['cart'])){
			// $_SESSION['cart'] is associative array that bookisbn => qty
			$_SESSION['cart'] = array();
// session to cart item 
			$_SESSION['total_items'] = 0;
			$_SESSION['total_price'] = '0.00';
		}

		if(!isset($_SESSION['cart'][$book_isbn])){
			$_SESSION['cart'][$book_isbn] = 1;
		} elseif(isset($_POST['cart'])){
			$_SESSION['cart'][$book_isbn]++;
			unset($_POST);
		}
	}

	// if save change button is clicked , change the qty of each bookisbn
	if(isset($_POST['save_change'])){
		foreach($_SESSION['cart'] as $isbn =>$qty){
			if($_POST[$isbn] == '0'){
				unset($_SESSION['cart']["$isbn"]);
			} else {
				$_SESSION['cart']["$isbn"] = $_POST["$isbn"];
			}
		}
	}

	// print out header here
	$title = "Your shopping cart";
	require "./template/header.php";

	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
		$_SESSION['total_price'] = total_price($_SESSION['cart']);
		$_SESSION['total_items'] = total_items($_SESSION['cart']);
?>
<!--  the form to show the items in the cart -->
   	<form action="cart.php" method="post">
	   	<table class="table">
	   		<tr>
	   			<th>Item</th>
	   			<th>Price</th>
	  			<th>Quantity</th>
	   			<th>Total</th>
	   		</tr>
	   		<?php 
		    	foreach($_SESSION['cart'] as $isbn => $qty){
					$conn = db_connect();
					$book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
			?>
			<tr>
			    <td> <!-- link to enter to the book that is in the cart -->
				  <a href="book.php?bookisbn=<?php echo $book['PID'];?>"><?php echo $book['Title'] . " by " . $book['Author_name']; ?></a>
				</td>
				<td><?php echo "$" . $book['Price']; ?></td>
				<td><input type="text" value="<?php echo $qty; ?>" size="2" name="<?php echo $isbn; ?>"></td>
				<td><?php echo "$" . $qty * $book['Price']; ?></td>
			</tr>
			<?php } ?>
		    <tr>
		    	<th>&nbsp;</th>
		    	<th>&nbsp;</th><!-- all the items and there price  -->
		    	<th><?php echo $_SESSION['total_items']; ?></th>
		    	<th><?php echo "$" . $_SESSION['total_price']; ?></th>
		    </tr>
	   	</table>
		   <button type="submit" class="btn btn-primary" name="save_change"><span class="glyphicon glyphicon-ok"></span>&nbsp;Save Changes</button>
	  
	</form>
	<br/><br/><!-- To do checkout to the cart and buying the books -->
	<a href="checkout.php" class="btn btn-primary">Go To Checkout</a> 
	<a href="books.php" class="btn btn-primary">Continue Shopping</a>
<?php
// code to show all the histroy of the customer all the book he bought from our website
	} else {
		echo "<p class=\"text-warning\">Your cart is empty! Please make sure you add some books in it!</p>";
	}
	if(isset($_SESSION['user'])){
	$customer=getCustomerIdbyEmail($_SESSION['email']);
	$customerid=$customer['id']; // selecting the book between the cart and cart items 
	$query="SELECT * FROM cart join cart_items join books join customers
		on customers.id='$customerid' and cart.clent_id='$customerid' and cart.cart_id=cart_items.cart_id and  cart_items.book_id	=books.PID";
	 $result=mysqli_query($conn,$query);
	 if(mysqli_num_rows($result)!=0){
	 echo '	<br><br><br><h4>Your Purchase History</h4><table class="table">
	 <tr>
		 <th>Item</th>
		 <th>Quantity</th>
		<th>Date</th>
	 </tr>';
		for($i = 0; $i < mysqli_num_rows($result); $i++){
			
			while($query_row = mysqli_fetch_assoc($result)){
				echo '<tr>
				<td>
				<a href="book.php?bookisbn=';
				echo $query_row['PID'];
				echo '">';
				echo '<img style="height:100px;width:80px"class="img-responsive img-thumbnail" src="/images/books/';
				echo $query_row['Image_path'];
				echo '">';
				echo ' </a>
				</td>
				<td>';
				echo $query_row['Quantity'];
				echo '
				</td>
				<td>';
				echo $query_row['Date_Published'];
				echo'
				</td>
				</tr>';
			}
		}
		echo '</table>';
	}
}
?>
<?php	 
	if(isset($conn)){ mysqli_close($conn); }
	 require_once "./template/footer.php";
	
	exit();
?>