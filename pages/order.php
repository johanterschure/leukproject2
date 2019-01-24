<?php
	require_once("../document_root.php");

	require_once(get_document_root() . "/includes/header.php");
	require ('../includes/ddb_connect.php');

	get_header('kaasch', '');

	session_start();
	$id=$_SESSION['user_id'];
	
	
?>
<p class="h2 text-center"> Your order history </p>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Order number</th>
      <th scope="col">order date</th>
      <th scope="col">payment mothod</th>
      <th scope="col">paid ?</th>
	  <th scope="col">More</th>
    </tr>
  </thead>



<?php
	function paid($paid)
	{
		if($paid == '1')
		{
			return "Yes";
		}else{
			return "No";
		}
	}
	$sql = ("SELECT o.`id` AS `orderid`, `date`, `name`, `is_paid`
			FROM `orders` o
			JOIN `paymentmethods` pm ON o.`paymentmethods_id` = pm.`id`
			WHERE `users_id`=$id
			ORDER BY o.`id`;");
	$result = mysqli_query($mysqli, $sql);
	if (mysqli_num_rows($result) > 0) {

		while($row = mysqli_fetch_assoc($result)) {

		echo "<tbody>
		<tr>
		  <th scope='row'>" . $row['orderid'] . "</th>
		  <td>" . $row['date'] . "</td>
		  <td>" . $row['name'] ."</td>
		  <td>" . paid($row['is_paid']) . "</td>
		  <td> <a href=\"order_x.php?order=".$row['orderid']."\">View </a>
		</tr>

	  </tbody>";

		  }
		echo "</table>";


	} 
		else {
		echo "<center><th scope='row'>No records found</th></center>";
	}

?>
<?php require_once(get_document_root() . "/includes/footer.php"); ?>
