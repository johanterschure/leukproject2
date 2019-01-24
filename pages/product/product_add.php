<?php
	require_once("../../document_root.php");
	require_once(get_document_root() . '/includes/ddb_connect.php');
	require_once(get_document_root() . "/includes/header.php");
    get_header('kaasch', 'kaasisbaas');


?>


<div class="container">
    <div class="row">
        <div class="col-12">
           <h2>Kaasch add</h2>
				<form method="post" action="verwerken1.php">
				<fieldset>
				<table>
				<tr><td>Name:</td><td> <input type ="text" name="name" class="form-control" size="25"></td></tr>
				<tr><td VALIGN=TOP>Description:</td><td>  <textarea name="description" class="form-control" rows="5" cols="30"></textarea></td></tr>
				<tr><td>Price(€0.00):</td><td> <input type ="text" name="price" class="form-control" size="25" placeholder = 'euros per 500 gram'></td></tr>
				<tr><td>BTW:</td><td> <input type ="radio" name="category" value="1" checked>21%(product)<input type ="radio" name="category" value="2">6%(food)</td></tr>
				<tr><td>Shelflife:</td><td> <input type ="text" name="shelflife" class="form-control" size="25" placeholder = 'years'></td></tr>
				</table><br>
				<input type="Submit" value="Add" class="btn btn-primary"> 
				<input type="reset" value="Empty" class="btn btn-primary">
				<input type="Button" value="Back" class="btn btn-primary" onclick="window.location.href='<?php echo get_relative_root();?>/pages/product/product_admin.php?id=<?php echo $productid ?>'">
				<form>


        </div>
    </div>
</div>




<?php require_once(get_document_root() . "/includes/footer.php"); ?>
