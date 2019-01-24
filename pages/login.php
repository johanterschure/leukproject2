<?php
require ('../includes/ddb_connect.php');


if (!empty($_POST)){

	$email = strtolower(mysqli_real_escape_string($mysqli, $_POST['email']));
	$password = mysqli_real_escape_string($mysqli, $_POST['password']);

	$result = $mysqli->query("SELECT * FROM users WHERE email_address ='$email'");

	if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)) {
			$password_sql = $row['password_hash'];
			$user_id = $row['id'];
			$is_admin = $row['is_admin'];
			$first_name = $row['first_name'];
		}

		if(password_verify($password,$password_sql)){
			session_start();
			$_SESSION["auth"]=true;
			$_SESSION["email"]=$email;
			$_SESSION["first_name"] = $first_name;
			$_SESSION["is_admin"] = $is_admin;
			$_SESSION["user_id"] = $user_id;

			if($is_admin == "1") {
				header("Location: admin/admin.php");
			
			}
			elseif($is_admin =="0") {
				header("Location: ../index.php?id=".$user_id."");
			
			}
		}
	} else {
		header("Location: login_form.php?message_code=3");
		}
}
?>
