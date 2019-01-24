<?php


	require ('../includes/ddb_connect.php');

	require_once("../document_root.php");

	require_once(get_document_root() . "/includes/header.php");
		get_header('kaasch', '');


	if (!empty($_POST['Submit'])){
		
		$email = strtolower(mysqli_real_escape_string($mysqli, $_POST["mail"]));

		$result = $mysqli->query("SELECT * FROM users WHERE email_address ='$email'");

		if (mysqli_num_rows($result) > 0){
			if($_POST['password'] == $_POST['password_rep'])
			{
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$query = "UPDATE users SET password_hash = '$password' WHERE email_address = '$email'";
				$change = $mysqli->query($query);
				if($change == true)
				{

					header("Location: login_form.php?message_code=11");
					exit;
				}
			}
				elseif('password'] != $_POST['password_rep']){
					
					header("Location: signup_form.php?message_code=13");
					exit;
					
				}
				else
				{
					header("Location: password_forgotten.php?message_code=2");
					exit;
				}
		
		 }else {
			header("Location:password_forgotten.php?message_code=10");

		 	}
	
	
?>
	
	
<?php require_once(get_document_root() . "/includes/footer.php"); ?>
