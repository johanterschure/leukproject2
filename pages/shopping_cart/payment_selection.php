<?php
	require_once("../../document_root.php");
	require_once(get_document_root().'/includes/ddb_connect.php');
	// require (get_document_root().'\includes/databases.php');

	require_once(get_document_root() . "/includes/header.php");
	get_header('kaasch', '');
	$db = $mysqli;
	$orderid = $_GET['orderid'];
?>
<div class='row'>
	<div class='col-3'></div>
	<div class='col-6'>
		<form method="post" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']), "?orderid=$orderid";?>" style="display: inline-block">

    <?php

		if (isset($_POST['confirm'])){
			$paymentmethods_id = $_POST['payment_method'];
			$sql = (
				"UPDATE `orders`
				SET `is_paid` = 1, `paymentmethods_id` = $paymentmethods_id
    		WHERE `id` = $orderid;"
			);
			mysqli_query($db, $sql);
			header("location: payment_success.php?orderid={$_GET['orderid']}");
		}
		$sql = (
			"SELECT o.`id`, `date`, `first_name`, `last_name`, p.`name` AS `productname`, `email_address`,
				`streetname`, `house_number`, `city`, `postal_code`, `country`, pm.`name` AS `paymentmethodname`, `amount`, `price`*`amount` AS `pricesum`
			FROM `orders` o
				JOIN `users` u ON u.`id` = o.`users_id`
	      JOIN `orders_has_products` ohp ON ohp.`orders_id` = o.`id`
	      JOIN `products` p ON p.`id` = ohp.`products_id`
	      JOIN `addresses` a ON a.`id` = u.`addresses_id`
	      JOIN `paymentmethods` pm ON pm.`id` = o.`paymentmethods_id`
	  WHERE o.`id` = $orderid AND `is_paid` = 0
	  ORDER BY `productname`;
		");
		$result = mysqli_query($db, $sql);
		$sumprice = 0;
		$runOnce = 1;
		if (mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				if ($runOnce == 1){
					echo("
					<h3>Delivery address</h3>
					<div class='mx-auto'>
						<div class='container'>
							<div class='row'>
								<div class='col-12'>
						<table class='table pl-5' style='display:inline; width:20rem'>
							<tbody>
								<tr>
									<td align='right'>".$row['first_name']." ".$row['last_name']."</td>
								</tr>
								</tbody>
								<tbody>
									<tr>
										<td colspan='2' align='right'>".$row['streetname']." ".$row['house_number']."</td>
									</tr>
								</tbody>
									<tbody>
										<tr>
											<td colspan='2' align='right'>".$row['city']." ".$row['postal_code']."</td>
										</tr>
									</tbody>
								<tbody>
									<tr>
										<td colspan='2' align='right'>".$row['country']."</td>
									</tr>
								</tbody>
							</table>
							<h3>Select payment method</h3>
							<table class='table pl-5' style='display:inline; width:20rem'>
								<tbody>
									<tr>
										<td><div class='form-check'>
											<input class='form-check-input' type='radio' name='payment_method' value='1' checked>
												PayPal
											</label>
										</div></td>
										<td><div class='form-check'>
											<input class='form-check-input' type='radio' name='payment_method' value='2'>
												iDeal
											</label>
										</div></td>
										<td><div class='form-check'>
											<input class='form-check-input' type='radio' name='payment_method' value='3'>
												Credit Card
											</label>
										</div></td>
										<td><div class='form-check'>
											<input class='form-check-input' type='radio' name='payment_method' value='4'>
												Bitcoin
											</label>
										</div></td>
									</tr>
								</tbody>
							</table>
							<p>
								<input class='btn btn-primary' type='submit' name='confirm' value='Confirm'>
								</form>
							</p>
							 <h3>Order overview</h3>
								<table class='table pl-5' style='display:inline; width:15rem'>
									<thead>
										<tr>
											<td><b>Product</b></td>
											<td><b>Amount</b></td>
											<td><b>Price</b></td>
										</tr>
									</thead>
									");
									$runOnce = 0;
				}
				echo ("
									<tbody>
									<tr>
										<td>".$row['productname']."</td>
										<td>".$row['amount']."</td>
										<td>".$row['pricesum']."</td>
									</tr>
								</tbody>
							");
							$sumprice += $row['pricesum'];
			}
			echo ("
								<tbody>
								<tr>
									<td></td>
									<td><b>Total</b></td>
									<td>$sumprice</td>
								</tr>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
");

		}
		else{
			$homepage = "../../index.php";
			echo "<h3>Something went wrong!</h3> Can't access this page. <p>You will be redirected to the home page in 5 seconds. If nothing happens, <a href=$homepage>click here.</a></p>";
		  header("refresh:5;url=$homepage");
		}
    ?>
		</form>
	</div>
	<div class='col-3'></div>
</div>

<?php require_once(get_document_root() . "/includes/footer.php"); ?>
