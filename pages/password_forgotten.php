<?php
	require_once("../document_root.php");

	require_once(get_document_root() . "/includes/header.php");
	get_header('kaasch', '');

		
?>

	<div class="container">
        <div class="row">
            <div class="col-12">
				<div class="mx-auto">
					<h2>Please fill your E-mail and Password in</h2>
					<div class="form-group">
							<label for="email">Email address:</label>
							<input name="email" type="text"  required title="please fill your email" class="form-control">
						</div>
						<div class="form-group">
							<label for="password">Password:</label>
							<input name="password" type="password" required title="please fill your password" class="form-control">
						</div>
						<div class="form-group">
							<label for="password">Repeat Password:</label>
							<input name="password_rep" type="password" required title="please fill your password again" class="form-control">
						</div>
						<div class="form-group">
							<input type="submit" name="Submit" value="Login" class="btn btn-primary">
							<input name="reset" type="reset" id="reset" value="Empty the form" class="btn btn-primary">
							<a href="password_forgotten.php" class="btn btn-primary"> I forgot my password</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	

<?php require_once(get_document_root() . "/includes/footer.php"); ?>