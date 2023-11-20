<!-- This code part of the purching process 
this page will be where the customer give his pay informtion-->
<?php
// starting the session
	session_start();
	// the function page to the functions from it 
	require_once "./include/dBFunctions.inc.php";
	// print out header here
	$title = "Purchase";
	require "./template/header.php";
	// making sure that we have access to the cart table in the database
	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
		$customer = getCustomerIdbyEmail($_SESSION['email']);
    ?>
	<!-- The table that will show the items that in the cart -->
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
		<tr>
			<td>Shipping</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>20.00</td>
		</tr>
		<tr>
			<th>Total Including Shipping</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo "$" . ($_SESSION['total_price'] + 20); ?></th>
		</tr>
	</table>
	<br>
	<br><!-- The customer informtion that we have in the database-->
	<h4 style="margin-left:-20px">Your Inforamtion</h4>
	<br>
	<form method="post" action="process.php" class="form-horizontal">
	<div class="form-group">
        <label for="exampleInputEmail1">username</label>
        <input type="text" class="form-control" aria-describedby="emailHelp" value="<?php echo $customer['email']?>" name="username">
    </div>

    <div class="form-group">
        <label for="inputAddress">Address</label>
        <input type="text" class="form-control" id="inputAddress" value="<?php echo $customer['address']?>" name="address">
    </div>
    <div class="form-row">
	<div class="form-group col-md-2">
        </div>
        <div class="form-group col-md-4">
        <label for="inputCity">City</label>
        <input type="text" class="form-control" id="inputCity" name="city" value="<?php echo $customer['city']?>">
        </div>
        <div class="form-group col-md-2">
        </div>
        <div class="form-group col-md-4">
        <label for="inputZip">Zip</label>
        <input type="text" class="form-control" id="inputZip" name="zipcode" value="<?php echo $customer['zipcode']?>">
        </div>
    </div>
	<br><!-- The customer informtion that we have in the database will be shown in this section -->
    <div class="form-group col-md-12" >
        <div class="form-group" >
            <div class="col-lg-10 col-lg-offset-2" style="margin-left:0px">
              	<button type="reset" class="btn btn-default">Cancel</button>
              	<button type="submit" class="btn btn-primary">Purchase</button>
            </div>
        </div>
    </form>
	<p class="lead">Please press Purchase to confirm your purchase, or Cancel  to reset the form .</p>
<?php
	} else {
		echo "<p class=\"text-warning\">Your cart is empty! Please make sure you add some books in it!</p>";
	}
	if(isset($conn)){ mysqli_close($conn); }
	require_once "./template/footer.php";
?>