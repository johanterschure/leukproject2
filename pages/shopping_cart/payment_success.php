<?php
  require_once("../../document_root.php");
  require_once(get_document_root().'/includes/ddb_connect.php');
  // require (get_document_root().'\includes/databases.php');

  require_once(get_document_root() . "/includes/header.php");
  get_header('kaasch', '');

  $orderid = $_GET['orderid'];
	$db = $mysqli;
  $homepage = "../../index.php";
  $sql = (
    "SELECT `name`
    FROM `paymentmethods` p
      JOIN `orders` o ON `paymentmethods_id` = p.`id`
      WHERE o.`id` = $orderid"
    );
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_assoc($result)){
			$paymentmethod = $row['name'];
    }

  echo "Thank you for your purchase!<br />You completed your purchase using $paymentmethod
  and will be redirected to the home page in 5 seconds. If nothing happens, <a href=$homepage>click here.</a>";
  header("refresh:5;url=$homepage");
?>


<?php require_once(get_document_root() . "/includes/footer.php"); ?>
