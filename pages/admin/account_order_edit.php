<?php
	require_once("../../document_root.php");
	require (get_document_root().'/includes/ddb_connect.php');
	// require (get_document_root().'\includes/databases.php');

	require_once(get_document_root() . "/includes/header.php");
	get_header('kaasch', '');
	$userid = $_GET['userid'];
	$orderid = $_GET['orderid'];

	$db = $mysqli;

?>
<form method="post" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']), "?userid=$userid", "&orderid=$orderid";?>" style="display: inline-block">
<?php
if($_SESSION['is_admin']){
	if (isset($_POST['confirm'])){
		$sql = (
			"SELECT a.`id` AS `addressid`
			FROM `addresses` a
				JOIN `users` u ON u.`addresses_id` = a.`id`
		    JOIN `orders` o ON o.`addresses_id` = a.`id`
			WHERE o.`id` = $orderid"
		);
		$result = mysqli_query($db, $sql);
		while($row = mysqli_fetch_assoc($result)){
			$addressid = $row['addressid'];
		}
		// var_dump($_POST);
		if (!empty($_POST['status_id'])){
			$status_id = $_POST['status_id'];
			$status_id = mysqli_real_escape_string($db, $status_id);
			$sql = (
				"UPDATE `orders`
				SET `status_id` = $status_id
				WHERE `id` = $orderid;
				");
				mysqli_query($db, $sql);
		}
		if (!empty($_POST['first_name'])){
			$first_name = $_POST['first_name'];
			$first_name = mysqli_real_escape_string($db, $first_name);
			$sql = (
				"UPDATE `users`
				SET `first_name` = '$first_name'
				WHERE `id` = $userid;
				");
				mysqli_query($db, $sql);
		}
		if (!empty($_POST['last_name'])){
			$last_name = $_POST['last_name'];
			$last_name = mysqli_real_escape_string($db, $last_name);
			$sql = (
				"UPDATE `users`
				SET `last_name` = '$last_name'
				WHERE `id` = $userid;
				");
				mysqli_query($db, $sql);
		}
		if (!empty($_POST['street'])){
			$street = $_POST['street'];
			$street = mysqli_real_escape_string($db, $street);
			$sql = (
				"UPDATE `addresses`
				SET `streetname` = '$street'
				WHERE `id` = $addressid;
				");
				mysqli_query($db, $sql);
		}
		if (!empty($_POST['house_number'])){
			$house_number = $_POST['house_number'];
			$house_number = mysqli_real_escape_string($db, $house_number);
			$sql = (
				"UPDATE `addresses`
				SET `house_number` = $house_number
				WHERE `id` = $addressid;
				");
				mysqli_query($db, $sql);
		}
		if (!empty($_POST['city'])){
			$city = $_POST['city'];
			$city = mysqli_real_escape_string($db, $city);
			$sql = (
				"UPDATE `addresses`
				SET `city` = '$city'
				WHERE `id` = $addressid;
				");
				mysqli_query($db, $sql);
		}
		if (!empty($_POST['postal_code'])){
			$postal_code = $_POST['postal_code'];
			$postal_code = mysqli_real_escape_string($db, $postal_code);
			$sql = (
			"UPDATE `addresses`
			SET `postal_code` = '$postal_code'
			WHERE `id` = $addressid;
			");
			mysqli_query($db, $sql);
		}
		if (!empty($_POST['country'])){
			$country = $_POST['country'];
			$country = mysqli_real_escape_string($db, $country);
			$sql = (
			"UPDATE `addresses`
			SET `country` = '$country'
			WHERE `id` = $addressid;
			");
			mysqli_query($db, $sql);
		}
		header("location: account_order.php?orderid={$_GET['orderid']}&message_code=12");
	}
	elseif(isset($_POST['cancel'])){
		header("location: account_order.php?orderid={$_GET['orderid']}");
	}
	$sql = (
		"SELECT `users_id`, o.`id`, `date`, s.`description` AS `statusdescription`, `first_name`, `last_name`, p.`name` AS `productname`, `email_address`,
			`streetname`, `house_number`, `city`, `postal_code`, `country`, pm.`name` AS `paymentmethodname`, `amount`, `price`*`amount` AS `pricesum`, a.`id` AS `addressid`
		FROM `orders` o
			JOIN `users` u ON u.`id` = o.`users_id`
      JOIN `orders_has_products` ohp ON ohp.`orders_id` = o.`id`
      JOIN `products` p ON p.`id` = ohp.`products_id`
      JOIN `addresses` a ON a.`id` = u.`addresses_id`
      JOIN `paymentmethods` pm ON pm.`id` = o.`paymentmethods_id`
      JOIN `status` s ON s.`id` = o.`status_id`
  WHERE `users_id` = $userid AND o.`id` = $orderid
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
				$addressid = $row['addressid'];
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
				<table class='table' style='display:inline; width:10rem'>
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
						<td><select class='selectpicker' name='status_id'>
							<option selected disabled>".$row['statusdescription']."</option>
							");
							$sql2 = (
							"SELECT `id`, `description` FROM `status`");
								$result2 = mysqli_query($db, $sql2);
									while($row2 = mysqli_fetch_assoc($result2)){
										echo ("
							<option value={$row2['id']}>{$row2['description']}</option>
							");
						}
						echo ("
						</select></td>
					</tr>
					</thread>
				</table>
				<table class='table pl-3' style='display:inline; width:10rem'>
				<thread>
					<tr>
						<td><b>Address</b></td><form method='post'>
						<td align='right'><input type='text' name = 'first_name' placeholder ='First name'></td>
						<td align='right'><input type='text' name = 'last_name' placeholder ='Last name'></td>
			    </tr>
					</thread>
					<thread>
			    <tr>
			      <td colspan='2' align='right'><input type='text' name='street' placeholder='Street name'></td>
						<td align='right'><input type='number' name='house_number' placeholder='House number'></td>
			    </tr>
					</thread>
					<thread>
			    <tr>
			      <td colspan='2' align='right'><input type='text' name='city' placeholder='City'></td>
						<td align='right'><input type='text' name='postal_code' placeholder='Postal code'></td>
			    </tr>
					</thread>
					<thread>
			    <tr>
			      <td colspan='3' align='right'><input type='text' name='country' placeholder='Country'></td>
					</tr>
					</thread>
				</table>
				<table class='table pl-3' style='display:inline; width:10rem'>
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
<table class='table pl-5' style='display:inline; width:15rem'>
<thread><tr>
<td>
<input class='btn btn-danger' type='submit' name='cancel' value='Cancel'>
</td>
<td>
	<input class='btn btn-primary' type='submit' name='confirm' value='Confirm Changes'>
	</form>
</td>
</tr>
</thread>
</table>

");

}
else {
	echo "This record is locked.";
}
?>

<?php require_once(get_document_root() . "/includes/footer.php"); ?>
