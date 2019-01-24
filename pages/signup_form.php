<?php

	require_once("../document_root.php");

	require_once(get_document_root() . "/includes/header.php");

	get_header('kaasch', '');
	//ession_start();


	//if (!($_SERVER["REQUEST_METHOD"] == "POST")){
		
?>

					<div class="container">
						<div class="row">
							<div class="col-12">
								<div class="mx-auto">
									<form action="signup.php" method="post">
									<h2> Making a new account</h2>
									All fields are mandatory except for State
									<div class="form-group">
										<label for="first_name">First Name:</label>
										<input type = "text" name = "first_name" pattern=".{2,}" required title="the first name must be at least two letters" class="form-control">
									</div>
									<div class="form-group">
										<label for="last_name">Last Name:</label>
										<input type = "text" name = "last_name" pattern=".{2,}"   required title="the last name must be at least two letters" class="form-control">
									</div>
									<div class="form-group">
										<label for="email">Email address:</label>
										<input type = "text" name = "mail" class="form-control">
									</div>
									<div class="form-group">
										<label for="exampleFormControlSelect1">Example select</label>
										<select name='gender' class="form-control" id="gender">
											<option value='male'>male</option>
											<option value='female'>female</option>
										</select>
									</div>
									<div class="form-group">
										<label for="tel_num">Telephone</label>
										<input type="tel" name="tel_num" pattern=".{10,}"   required title="10 numbers minimum" class="form-control">
									</div>
									<div class="form-group">
										<label for="street_name">Street Name</label>
										<input type = "text" name = "street_name" pattern=".{3,}"   required title="3 characters minimum" class="form-control">
									</div>
									<div class="form-group">
										<label for="house_number">House Number</label>
										<input type = "text" name = "house_number" pattern=".{1,}"   required title="at least one number" class="form-control">
									</div>
									<div class="form-group">
										<label for="Post_code">Postal Code</label>
										<input type = "text" name = "Post_code" class="form-control">
									</div>
									<div class="form-group">
										<label for="city">city</label>
										<input type = "text" name = "city" pattern=".{2,}"   required title="the city name must be at least two letters" class="form-control">
									</div>
									<div class="form-group">
										<label for="state">State</label>
										<input type="text" name="state" class="form-control">
									</div>
									<div class="form-group">
										<label for="country">Country</label>
										<input type = "text" name = "country" pattern=".{2,}"   required title="the country name must be at least two letters" class="form-control">
									</div>
									<div class="form-group">
										<label for="password">Password</label>
										<input type = "password" name = "pwd" pattern=".{6,}"   required title="the password must be at least 6 characters" class="form-control">
									</div>
									<div class="form-group">
										<label for="password_rep">Password repeat</label>
										<input type = "password" name = "pwd_rep" pattern=".{6,}"   required title="Please fill the password again" class="form-control">
									</div>
										<input type="submit" name='signup' value="signup" class="btn btn-primary">
									</form>
								</div>
							</div>
						</div>
					</div>

<?php

 require_once(get_document_root() . "/includes/footer.php");
 ?>
