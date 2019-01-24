	
<?php
	require_once("../document_root.php");

	require_once(get_document_root() . "/includes/header.php");

	get_header('kaasch', '');
	
	require ('../includes/ddb_connect.php');


	if(isset($_POST['signup']))
		{
			$first_name = mysqli_real_escape_string($mysqli, $_POST["first_name"]);
			$first_name = ucwords($first_name);
			$last_name = mysqli_real_escape_string($mysqli, $_POST["last_name"]);
			$last_name = ucwords($last_name);
			$mail = strtolower(mysqli_real_escape_string($mysqli, $_POST["mail"]));
			$sql = "SELECT email_address FROM users WHERE email_address = '$mail'";
			$result_mail = mysqli_query($mysqli, $sql);
			if(!preg_match("/^[A-Za-z -]*$/", $first_name) || !preg_match("/^[A-Za-z -]*$/", $last_name))
			{
				header("Location: signup_form.php?message_code=8");
				exit;
			}
			if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
			{
				header("Location: signup_form.php?message_code=6");
				exit;
			}
			if (mysqli_num_rows($result_mail) > 0 )
			{

				header("Location: signup_form.php?message_code=7");
				exit;
			}
			$gender = $_POST['gender'];
			if($gender == 'male')
			{
				$gender = 1;
			}
			elseif($gender == 'female')
			{
				$gender = 0;
			}
			$telephone_number = mysqli_real_escape_string($mysqli, $_POST['tel_num']);
			$street_name = mysqli_real_escape_string($mysqli, $_POST['street_name']);
			$house_number = mysqli_real_escape_string($mysqli, $_POST['house_number']);
			$city = mysqli_real_escape_string($mysqli, $_POST['city']);
			$postcode = mysqli_real_escape_string($mysqli, $_POST['Post_code']);
				if(!preg_match('/^[1-9]{1}[0-9]{3}[A-Z]{2}$/', $postcode)) {
				header("Location: signup_form.php?message_code=9");
				exit;
			}
			$state = mysqli_real_escape_string($mysqli, $_POST['state']);
			$country = mysqli_real_escape_string($mysqli, $_POST['country']);
			if($_POST['pwd'] == $_POST['pwd_rep'])
			{
				$password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
				
			}else{
				
				header("Location: signup_form.php?message_code=13");
				exit;
			}
			//now begining with the real work
				$query1 = "INSERT INTO addresses(streetname, house_number, city, postal_code, state, country)";
				$query1 .= " VALUES ('$street_name', '$house_number', '$city', '$postcode', '$state', '$country')";
				$controle1 = mysqli_query($mysqli,$query1);
					if ($controle1 == TRUE) {
						echo "";
						}

				$query2 = "SELECT MAX(id) AS `id` FROM addresses";
				$fetched_id = mysqli_query($mysqli,$query2);
					if ($fetched_id == TRUE) {

						while($sql_adres_id = mysqli_fetch_assoc($fetched_id))
						{
							$controle2 = $sql_adres_id['id'];
						}
					}

				$query = "INSERT INTO users(first_name, last_name, email_address, telephone_number, gender, addresses_id, password_hash,created_at,updated_at) ";
				$query .= " VALUES ('$first_name', '$last_name', '$mail', '$telephone_number', '$gender', '$controle2', '$password',now(),now())";

					if ($mysqli->query($query)) {
						$sql = "SELECT MAX(id) AS `id` FROM users";
						$fetched_id = mysqli_query($mysqli,$sql);
						if ($fetched_id == TRUE){

						while($sql_adres_id = mysqli_fetch_assoc($fetched_id))
						{
							$user_id = $sql_adres_id['id'];
						}}
						$index="../index.php";
						$_SESSION['loggedin']=true;
						echo header("Location: login_form.php?message_code=5");
						echo "<a href=".$index."?id=".$user_id."> Go to home page </a>";

						}else	{
							
						header("Location: signup_form.php?message_code=4");
					}

		}