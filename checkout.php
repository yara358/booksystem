<!-- code to show  checkout process for the user  -->
<?php
	session_start();
	// bringing all the function from the data
	require_once "./include/dBFunctions.inc.php";
	// print the title of the page 
	$title = "Checking out";
	// print out header here
	require "./template/header.php";
	// to make sure that user in inside 
	if(!isset($_SESSION['user'])){
		echo '<div class="alert alert-danger" role="alert">
		You Need to <a href="Signin.php">Signin</a> First! 
	  </div>';
	}// entring the cart session so we can see what items is customer buying 
	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
?><!-- the table to show the items-->
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
					$book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));// getting the book by its PID 
			?>
		<tr>
			<td><?php echo $book['Title'] . " by " . $book['Author_name']; ?></td>
			<td><?php echo "$" . $book['Price']; ?></td>
			<td><?php echo $qty; ?></td>
			<td><?php echo "$" . $qty * $book['Price']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo $_SESSION['total_items']; ?></th>
			<th><?php echo "$" . $_SESSION['total_price']; ?></th>
		</tr>
	</table>
	<?php 
	// teh user will have all his information in the purchase section 
		if(isset($_SESSION['user'])){
			echo '<form method="post" action="purchase.php" class="form-horizontal">
			<div class="form-group" style="margin-left:0px">
				<input type="submit" name="submit" value="Purchase" class="btn btn-primary" >
				<a href="cart.php" class="btn btn-primary">Edit Cart</a> 
			</div>
		</form>
		<p class="lead">Please press Purchase to confirm your purchase, or Edit Cart to add or remove items.</p>';
		}
	?>
	
<?php
	} else {
		echo "<p class=\"text-warning\">Your cart is empty! Please make sure you add some books in it!</p>";
	}
	if(isset($conn)){ mysqli_close($conn); }
	require_once "./template/footer.php";
?>