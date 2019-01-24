<?php
	require_once("../../document_root.php");
	require (get_document_root().'/includes/ddb_connect.php');
	// require (get_document_root().'\includes/databases.php');

	require_once(get_document_root() . "/includes/header.php");
	get_header('kaasch', '');
	$userid = $_GET['user_id'];
if($_SESSION['is_admin']){
$db = $mysqli;

	$sql = (
		"SELECT `users_id`, o.`id` AS `orderid`, `date`, s.`description` AS `statusdescription`, `first_name`, `last_name`, sum(`price`*`amount`) AS `total`
			FROM `orders` o
				JOIN `users` u ON o.`users_id` = u.`id`
				JOIN `orders_has_products` ohp ON o.`id` = ohp.`orders_id`
				JOIN `products` p ON ohp.`products_id` = p.`id`
				JOIN `status` s ON s.`id` = o.`status_id`
      GROUP BY o.`id`
			HAVING `users_id` = $userid;
			");
			$result = mysqli_query($db, $sql);
			$runOnce = 1;
			if (mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					if ($runOnce == 1){
						$userid = $row['users_id'];
						echo ("
						<div class='container'>
						<table class='table'>
							<thread>
							<tr>
								<td><b>User ID: </b>$userid</td>
								</tr>
							</thread>
							<thread>
							<tr>
								<td>".$row['last_name'].", ".$row['first_name']."</td>
							</tr>
							</thread>
						</table>
						<br />
						<h3>Order overview</h3>
						  <table class='table'>
							<thread>
						    <tr>
						      <td><b>Order Number</b></td>
						      <td><b>Date</b></td>
						      <td><b>Order Total</b></td>
						      <td><b>Status</b></td>
						      <td></td>
						    </tr>
								</thread>
						");
						$runOnce = 0;
					}
					$status = $row['statusdescription'];
					$orderid = $row['orderid'];
					$date = date_create($row['date']);
					$date = date_format($date, "d/m/Y");
					echo ("
					<thread>
					<tr>
						<td>$orderid</td>
						<td>$date</td>
						<td>".$row['total']."</td>
						<td>$status</td>
						<td><b><a href='account_order.php?orderid=$orderid'>></a></b></td>
					</tr>
					</thread>
					</div>
				");
			}
			echo "</table>";
		}
		else {
			echo "<h3>No records found</h3>";
		}
	}
		else {
			echo "This record is locked.";
		}
?>
  <?php require_once(get_document_root() . "/includes/footer.php"); ?>
