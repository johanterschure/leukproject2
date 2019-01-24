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
           <h2>Kaasch delete</h2>
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
				<td align='right'><b> DELETE:&nbsp;&nbsp;</b></td>
				</tr>
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
				<tr><td>&nbsp;&nbsp;</td></tr>
				<tr>
				<td align='right'>
				<form action="<?php echo($_SERVER["PHP_SELF"]);?>" method="get">
				<input type="hidden" name="confirmation" value="1">
				<input name="id" type="text" class="d-none" value="<?php echo "$productid" ?>">
				<input type="Submit" class="btn btn-primary" value="Yes, delete">
				</form>
				</td>
				<td>
				<input type="Button" value="Back" class="btn btn-primary" onclick="window.location.href='<?php echo get_relative_root();?>/pages/product/product_admin.php?id=<?php echo $productid ?>'">
				</form>
				</td>
				</tr>
				<tr><td>
				<?php
				if (isset($_GET["confirmation"])){
					$query = "DELETE FROM products WHERE id = $productid;";
					$result = mysqli_query($mysqli, $query) or die('(products_has_orders)');
					Echo "Product has been deleted.";
				}
				?>
				</td>
				</tr>
				</table>
        </div>
    </div>
</div>




<?php require_once(get_document_root() . "/includes/footer.php"); ?>
