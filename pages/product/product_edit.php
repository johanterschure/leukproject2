<?php
	require_once("../../document_root.php");
	require_once(get_document_root() . '/includes/ddb_connect.php');
	require_once(get_document_root() . "/includes/header.php");
    get_header('kaasch', 'kaasisbaas');


?>

<?php
?>

<div class="container">
    <div class="row">
        <div class="col-12">
           <h2>Kaasch edit</h2>
            <?php
			
				$productid = $_POST["id"];
				echo "<img src=\"../../images/".$productid.".jpg\" alt=\"kaas\" height=\"300\" width=\"300\">";

				$query = "SELECT * FROM products WHERE id = $productid;";
				$result = mysqli_query($mysqli, $query);
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						$name = $row["name"];
						$description = $row["description"];
						$price = $row["price"];
						$shelflife = $row["shelflife"];
					}
				}
				
				if (isset($_POST["confirmation"])){
					$name = $_POST["name"];
					$description = $_POST["description"];
					$price = $_POST["price"];
					$shelflife = $_POST["shelflife"];
					$query="UPDATE products SET name='$name', description='$description', price='$price', shelflife='$shelflife' WHERE id = $productid;";
					$result = mysqli_query($mysqli, $query);
				}
			?>
				<h3>Edit:</h3>
				<form action="<?php echo($_SERVER["PHP_SELF"]);?>" method="post">
				<input type="hidden" name="confirmation" value="1">
				<input type="hidden" name="id" type="text" value="<?php echo "$productid" ?>">
				
				<table>
				<tr><td>Name:</td><td><input type="text" name="name" class="form-control" value="<?php echo($name);?>"></td></tr>
				<tr><td>Description: </td><td><input type="text" name="description" class="form-control" value="<?php echo($description);?>"></td></tr>
				<tr><td>Price:</td><td> <input type="text" name="price" class="form-control" value="<?php echo($price);?>"></td></tr>
				<tr><td>Shelflife:</td><td> <input type="text" name="shelflife" class="form-control" value="<?php echo($shelflife);?>"></td></tr>
				</table>
		
				<hr>
				<input type ="Submit" value="Yes, edit" class="btn btn-primary">
				<input type="Button" value="Back" class="btn btn-primary" onclick="window.location.href='<?php echo get_relative_root();?>/pages/product/product_admin.php?id=<?php echo $productid ?>'">
				</form>


        </div>
    </div>
</div>




<?php require_once(get_document_root() . "/includes/footer.php"); ?>
