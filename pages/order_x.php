<?php
	require_once("../document_root.php");

	require_once(get_document_root() . "/includes/header.php");
	require ('../includes/ddb_connect.php');
	get_header('kaasch', '');

	session_start();
	$id=$_GET['order'];
	$userid=$_SESSION['user_id'];

	$sql = (
		"SELECT `users_id`
		FROM `orders`
		WHERE `id`=$id;
		"
	);
	$result = mysqli_query($mysqli, $sql);
	while($row = mysqli_fetch_assoc($result)){
		$sqluserid = $row['users_id'];
	}
	if(isset($_GET['order']) && $userid == $sqluserid){
?>

			<p class="h2 text-center"> Order Number <?php echo $id; ?> </p>
			<table class="table">
			  <thead>
				<tr>
				  <th scope="col">Product Name</th>
				  <th scope="col">Product Price</th>
				  <th scope="col">Amount purchased</th>
				  <th scope="col">Total paid is Euros</th>
				</tr>
			  </thead>
			';

<?php


		$sql = (
		"SELECT p.`name`, a.`amount`, p.`price`, (a.`amount`*p.`price`) AS `total`
		FROM `orders_has_products` a JOIN `products` p
		ON a.`products_id` = p.`id` AND a.`orders_id`  = $id;
		");
		$total = 0;
		$result = mysqli_query($mysqli, $sql);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				echo ("
				<tbody>
					<tr>
					  <th scope='row'>" . $row['name'] . "</th>
					  <td>" . $row['price'] . "</td>
					  <td>" . $row['amount'] . "</td>
					  <td>" . $row['total'] ."</td>
					</tr>
				</tbody>
			");
			$total += $row['total'];
			}
  	}
echo "
<tboy>
<tr>
	<td colspan=3><b>Total</b></td>
	<td><b>$total</b></td>
</tr>
</tboy>
</table>";
		}
		else{
			echo "Sorry an error occurred while getting the information, please try again.";
		}
?>

























<?php require_once(get_document_root() . "/includes/footer.php"); ?>
