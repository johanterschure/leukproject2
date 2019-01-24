<?php
	require_once("../../document_root.php");
	require_once(get_document_root() . '/includes/ddb_connect.php');

	require_once(get_document_root() . "/includes/header.php");
    get_header('kaasch', '');
    if (!login_check()) {
        header("Location: " . get_relative_root() . "/pages/shopping_cart");
    }
?>

<div class="container">
    <div class="row">
        <div class="col-12">
           <h2>Finalize order</h2>

            <form method="post" action="<?php echo get_relative_root(); ?>/logic/shopping_cart/finalize_order.php">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" name="useDefault">
                    <label class="form-check-label">
                        Use customer address
                    </label>
                </div>
                <div class="form-group">
                    <label>Street Name:</label>
                    <input name="street_name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>House Number:</label>
                    <input name="house_number" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>City:</label>
                    <input name="city" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Postal Code:</label>
                    <input name="postal_code" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>State:</label>
                    <input name="state" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Country:</label>
                    <input name="country" type="text" class="form-control">
                </div>
                <input type="submit"  name="Submit" value="Order" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<?php require_once(get_document_root() . "/includes/footer.php"); ?>