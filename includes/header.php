<?php
session_start();

function login_check() {
  if(session_id() == '') {
    session_start();
  }
  if(isset($_SESSION["auth"])){
    if($_SESSION["auth"]==true) {
      return true;
    }else{
      return false;
    }
  }
}

/**
 * @param string $title Title of the page
 * @param string $description Description of the page
 */
function get_header($title,$description ){
$relative_path = get_relative_root();
if(session_id() == '') {
    session_start();
}

echo <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{$title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{$description}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{$relative_path}/css/main.css">
    <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
EOT;
//error handeling meldingen maken hier voor elke error massage even het volgende nummer gebruiken
//TODO: Apart bestand a.u.b.
if (isset($_GET['message_code'])) {
  switch($_GET['message_code']) {
    case 1:
      echo"<div class='alert alert-success'>";
      echo '<strong>Success!</strong> Indicates a successful or positive action.';
      break;
    case 2:
      echo '<div class="alert alert-danger">';
      echo '<strong>Warning!</strong> somthing whent wrong please contact support.';
      break;
    case 3:
      echo '<div class="alert alert-info">';
      echo '<strong>oops!</strong> the combination of email and email and password is incorrect.';
      break;
    case 4:
      echo '<div class="alert alert-danger">';
      echo '<strong>Warning!</strong> Something went wrong please try again.';
      break;
	case 5:
      echo"<div class='alert alert-success'>";
      echo '<strong>Success!</strong> You have signed up successfully.';
      break;
    case 6:
      echo '<div class="alert alert-info">';
      echo '<strong>oops!</strong> The email you entred isn`t valid.';
      break;
	case 7:
      echo '<div class="alert alert-info">';
      echo '<strong>oops!</strong> The E-mail is already Taken.';
      break;
	case 8:
      echo '<div class="alert alert-info">';
      echo '<strong>oops!</strong> The name can only be letters.';
      break;
	case 9:
      echo '<div class="alert alert-info">';
      echo '<strong>oops!</strong> Postal code must be of this format 9999XX.';
      break;
	case 10:
      echo '<div class="alert alert-info">';
      echo '<strong>oops!</strong> Sorry but we couldn`t find your E-mail please try again.';
      break;
	case 11:
      echo"<div class='alert alert-success'>";
      echo '<strong>Success!</strong> Your password has ben changed successfully.';
      break;
	case 12:
      echo"<div class='alert alert-success'>";
      echo '<strong>Success!</strong> You have edited the order.';
      break;
	case 13:
      echo '<div class="alert alert-info">';
      echo '<strong>oops!</strong> Password and Password repeat don`t match please try again.';
      break;
  }
 echo "</div>";
}
echo <<<EOT
<body>
  <nav class="navbar navbar-expand-lg navbar-light sticky-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="{$relative_path}">Kaasch</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
EOT;
// veranderen van de header als je ingelogd bent
if (login_check()) {
  echo "<a class='nav-link js-scroll-trigger' href='{$relative_path}/pages/user.php'>welcome {$_SESSION['first_name']}</a> ";
} else {
    echo "<a class='nav-link js-scroll-trigger' href='{$relative_path}/pages/login_form.php'>login</a>";
}


echo <<<EOT
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href='{$relative_path}/pages/about.php'>About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href='{$relative_path}/pages/shop.php'>shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href='{$relative_path}/pages/contact.php'>Contact</a>
          </li>
EOT;
// TODO: Display amount of items in cart
$cartcount = 0;
if (isset($_SESSION["shoppingcart"])) {
  $cartcount = count($_SESSION["shoppingcart"]);
}
echo <<<EOT
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="{$relative_path}/pages/shopping_cart">
              Cart
              <span class="fa-layers fa-fw fa-2x" data-fa-transform="down-2">
                <i class="fas fa-shopping-cart" data-fa-transform="shrink-4 down-3"></i>
EOT;
if ($cartcount != 0) echo "<span class='fa-layers-counter' style='ackground:Tomato'>" . $cartcount . "</span>";
echo <<<EOT
              </span>
            </a>
          </li>
EOT;

if (login_check()) {
  if ($_SESSION['is_admin']) {
    echo "<li class='nav-item'>
      <a class='nav-link js-scroll-trigger' href='{$relative_path}/pages/admin/admin.php'>admin panel</a>
    </li>";
  }
  echo "<li class='nav-item'>
    <a class='nav-link js-scroll-trigger' href='{$relative_path}/pages/logout.php'>logout</a>
  </li>";
}
echo <<<EOT
        </ul>
      </div>
    </div>
  </nav>
EOT;
session_write_close();
}
?>
