<?php
	require_once("../document_root.php");
	require_once(get_document_root() . '/includes/ddb_connect.php');
	require_once(get_document_root() . "/includes/header.php");
    get_header('kaasch', 'kaasisbaas');
?>

	<div class="container">
			<div class="row product-overview pt-4">
					<div class="col-12 py-4">
						<h2>Kaasch shop</h2><br>
					

					<form action="<?php echo($_SERVER["PHP_SELF"]);?>" method="get">
						<select name="Order" class="form-control">
						<option value="createdDESC">Upload date</option>
						<option value="priceASC">Price low - high</option>
						<option value="priceDESC">Price high - low</option>
						<option value="nameASC">Title A - Z</option>
						<option value="nameDESC">Title Z - A</option>
						</select><br>
						<input type="submit" value="Order" class="btn btn-primary">
						</form>
					</div>
					<?php
					if(isset($_GET["Order"])){
						if($_GET["Order"] == "priceASC"){
							$result = $mysqli->query("SELECT * FROM products ORDER BY price ASC;");
						}
						elseif($_GET["Order"] == "priceDESC"){
							$result = $mysqli->query("SELECT * FROM products ORDER BY price DESC;");
						}
						elseif($_GET["Order"] == "nameASC"){
							$result = $mysqli->query("SELECT * FROM products ORDER BY name ASC;");
						}
						elseif($_GET["Order"] == "nameDESC"){
							$result = $mysqli->query("SELECT * FROM products ORDER BY name DESC;");
						}
						else{
							$result = $mysqli->query("SELECT * FROM products ORDER BY created_at DESC;");
						}
					}
					else{
							$result = $mysqli->query("SELECT * FROM products ORDER BY created_at DESC;");
						}
						
					if (mysqli_num_rows($result) > 0){
						$relative_root = get_relative_root();
						while($row = mysqli_fetch_assoc($result)) {
							$productpath;
							$relative_root = get_relative_root();
							//echo $row['name'] . " | " . $row['description']. " | " . $row['price']. " | " . $row['shelflife'];
							if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
								$buttons = "
								<a class='btn btn-secondary' href='{$relative_root}/pages/product/product_admin.php?id={$row["id"]}'>Administrate</a>
								<a class='btn btn-secondary' href='{$relative_root}/pages/product/product.php?id={$row["id"]}'>View</a>
								";
							} else {
								$buttons = "
								<a class='btn btn-secondary' href='{$relative_root}/pages/product/product.php?id={$row["id"]}'>View</a>
								";
							}
							echo <<<EOT
							
							<div class="col-4">
								<div class="product">
									<div class="product-image">
										<img src="{$relative_root}/images/{$row["id"]}.jpg" />
									</div>
									<div class="product-name">
										<h3>{$row['name']}</h3>
									</div>
									<div class="product-order">
										<span>Price: &euro;{$row['price']}</span>
										<form method="post" action="{$relative_root}/logic/shopping_cart/add_product.php">
											<input name="product_id" type="text" class="d-none" value="{$row["id"]}">
											<input name="return_url" type="text" class="d-none" value="">
											<button type="submit" name="submit" class="btn btn-secondary"><i class="fas fa-shopping-cart"></i></button>
										</form>
										{$buttons}
									</div>
								</div>
							</div>
EOT;
						}
					} else {
						echo "Error loading products from database";
					}


					?>

			</div>
	</div>




<?php require_once(get_document_root() . "/includes/footer.php"); ?>
