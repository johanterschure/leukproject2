<?php
	require_once("../../document_root.php");
	require_once(get_document_root() . '/includes/ddb_connect.php');
	require_once(get_document_root() . "/includes/header.php");
    get_header('kaasch', 'kaasisbaas');
	// require_once(get_document_root() . "/includes/admin_page.php");

?>

<?php
?>

<div class="container">
    <div class="row">
        <div class="col-12">
           <h2>Kaasch product</h2>
            <?php
				$productid = $_GET["id"];
				echo "<img src=\"../../images/".$productid.".jpg\" alt=\"kaas\" height=\"600\" width=\"600\">";
				$query = "SELECT * FROM products WHERE id = $productid;";
				$result = mysqli_query($mysqli, $query);
				$row = mysqli_fetch_assoc($result)
				?>


				<table style="display: inline-block;">
				<col width = 80><col width = 150>
				<tr>
				<td align='right'><b>Name:&nbsp;&nbsp;</b></td>
				<td><?php echo $row['name'] ?></td>
				</tr>
				<tr>
				<td align='right' VALIGN=TOP><b>Description:&nbsp;&nbsp;</b></td>
				<td><?php echo $row['description'] ?></td>
				</tr>
				<tr>
				<td align='right' VALIGN='TOP'><b>Price:&nbsp;&nbsp;</b></td>
				<td><?php echo "€".$row['price']." euro a 500g "; ?></td>
				</tr>
				<tr>
				<td align='right'><b>Shelflife:&nbsp;&nbsp;</b></td>
				<td><?php echo $row['shelflife']." year"; ?></td>
				</tr>
				<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
				</tr>
				<tr>
				<td align='right'>
				<form method="post" action="<?php echo get_relative_root();?>/logic/shopping_cart/add_product.php">
					<input name="product_id" type="text" class="d-none" value="<?php echo "$productid" ?>">
					<input name="return_url" type="text" class="d-none" value="/pages/product/product_admin.php?id=<?php echo "$productid" ?>">
					<button type="submit" name="submit" class="btn btn-secondary"><i class="fas fa-shopping-cart"></i></button>
				</form>
				</td>
				<td>
				<form method="POST" action="product_edit.php">
				<input name="id" type="text" class="d-none" value="<?php echo "$productid" ?>">
				<button type="submit" class="btn btn-secondary"><i class="fa fa-wrench"></i></button>
				</form>
				</td>
				</tr>
				<tr>
				<td align='right'>
				<form method="get" action="product_delete.php">
				<input name="id" type="text" class="d-none" value="<?php echo "$productid" ?>">
				<button type="submit" class="btn btn-secondary"><i class="fa fa-window-close"></i></button>
				</form>
				</td>
				<td>
				<form method="post" action="product_add.php">
				<input name="product_id_add" type="text" class="d-none">
				<button type="submit" class="btn btn-secondary"><i class="fa fa-plus-circle"></i></button>
				</form>
				</td>
				</tr>
				</table>


        </div>
    </div>
</div>




<?php require_once(get_document_root() . "/includes/footer.php"); ?>