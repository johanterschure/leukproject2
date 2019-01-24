<?php
	require_once("../../document_root.php");
	// require (get_document_root().'\includes/databases.php');
	require (get_document_root().'/includes/ddb_connect.php');

	require_once(get_document_root() . "/includes/header.php");
	get_header('kaasch', '');
	$orderid = $_GET['orderid'];
if($_SESSION['is_admin']){
		$db = $mysqli;
		$sql = (
			"SELECT `users_id`, o.`id`, `date`, s.`description` AS `statusdescription`, `first_name`, `last_name`, p.`name` AS `productname`, `email_address`,
				`streetname`, `house_number`, `city`, `postal_code`, `country`, pm.`name` AS `paymentmethodname`, `amount`, `price`*`amount` AS `pricesum`
			FROM `orders` o
				JOIN `users` u ON u.`id` = o.`users_id`
	      JOIN `orders_has_products` ohp ON ohp.`orders_id` = o.`id`
	      JOIN `products` p ON p.`id` = ohp.`products_id`
	      JOIN `addresses` a ON a.`id` = u.`addresses_id`
	      JOIN `paymentmethods` pm ON pm.`id` = o.`paymentmethods_id`
	      JOIN `status` s ON s.`id` = o.`status_id`
	  WHERE o.`id` = $orderid
	  ORDER BY `productname`;
		");
		$result = mysqli_query($db, $sql);
		$sumprice = 0;
		$runOnce = 1;
		if (mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				if ($runOnce == 1){
					$date = date_create($row['date']);
					$time = date_format($date, "H:i:s");
					$date = date_format($date, "d/m/Y");
					$userid = $row['users_id'];
					echo ("
					<div class='container'>
					<table class='table' style='width:10rem'>
					<thread>
					<tr>
						<td><b>User ID: </b><a href='account_order_overview.php?user_id={$userid}'>$userid</a></td>
						</tr>
					</thread>
					<thread>
					<tr>
						<td>".$row['last_name'].", ".$row['first_name']."</td>
					</tr>
					</thread>
					</table>
					<br />
					<h3>Order Information</h3>
					<table class='table' style='display:inline; width:15rem'>
						<thread>
						<tr>
							<td><b>Order Number</b></td>
							<td>$orderid</td>
						</tr>
						</thread>
						<thread>
						<tr>
							<td><b>Date</b></td>
							<td>$date</td>
						</tr>
						</thread>
						<thread>
						<tr>
							<td><b>Time</b></td>
							<td>$time</td>
						</tr>
						</thread>
						<thread>
						<tr>
							<td><b>Status</b></td>
							<td>".$row['statusdescription']."</td>
						</tr>
						</thread>
					</table>
					<table class='table pl-5' style='display:inline; width:15rem'>
					<thread>
						<tr>
							<td><b>Address</b></td>
							<td align='right'>".$row['first_name']." ".$row['last_name']."</td>
						</tr>
						</thread>
						<thread>
						<tr>
							<td colspan='2' align='right'>".$row['streetname']." ".$row['house_number']."</td>
						</tr>
						</thread>
						<thread>
						<tr>
							<td colspan='2' align='right'>".$row['city']." ".$row['postal_code']."</td>
						</tr>
						</thread>
						<thread>
						<tr>
							<td colspan='2' align='right'>".$row['country']."</td>
						</tr>
						</thread>
					</table>
					<table class='table pl-5' style='display:inline; width:15rem'>
					<thread>
						<tr>
							<td><b>Payment Method</b></td>
						</tr>
						</thread>
						<thread>
						<tr>
							<td>".$row['paymentmethodname']."</td>
						</tr>
						</thread>
						");
					if ($row['paymentmethodname'] == 'PayPal'){
						echo("
						<thread>
							<tr>
								<td>".$row['email_address']."</td>
							</tr>
							</thread>
						");
					}
					echo ("
						</table>
						<br />
						<h5 class='pt-5'>Products</h5>
						<table class='table'>
						<thread>
						<tr>
						<td><b>Product</b></td>
						<td><b>Amount</b></td>
						<td><b>Price</b></td>
						</tr>
						</thread>
						<thread>
					");
					$runOnce = 0;
				}
				$sumprice += $row['pricesum'];
			echo ("
				<thread>
					<tr>
						<td>".$row['productname']."</td>
						<td>".$row['amount']."</td>
						<td>€".$row['pricesum']."</td>
					</tr>
				</thread>
			");
		}
		echo ("
		<thread>
		<tr>
		<td colspan='2' align='right'><b>Total</b></td>
		<td>€".number_format($sumprice, 2)."</td>
		</tr>
		</tread>
		</table>
		");
	}
	echo ("
	<form method='post' action='account_order_edit.php?orderid=$orderid&userid=$userid'>
	<input class='btn btn-primary' type='submit' name='edit' value='Edit order'>
	</form>
	");
}
else {
	echo "This record is locked.";
}
?>
  <?php require_once(get_document_root() . "/includes/footer.php"); ?>
