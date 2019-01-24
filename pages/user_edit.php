<?php
require_once("../document_root.php");
require_once(get_document_root() . "/includes/header.php");
get_header('kaasch', '');
require_once(get_document_root() . "/includes/ddb_connect.php");

  $user_id = $_SESSION['user_id'];

  $result = $mysqli->query("SELECT users.first_name, users.last_name, users.gender, users.email_address, users.telephone_number, users.addresses_id, addresses.city, addresses.country, addresses.house_number, addresses.postal_code, addresses.state, addresses.streetname FROM users
  INNER JOIN addresses ON addresses.id = users.addresses_id WHERE users.id={$user_id}");
  $row = $result->fetch_assoc();
  $male_select = '';
  $female_select = '';
  if ($row['gender']==1){
    $male_select = 'selected';
  } else {
    $female_select = 'selected';
  }

echo <<<EOT
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>gebruikers</h1>
            </div>
          </div>

          <form action="update_user.php?user_id={$user_id}&addresses_id={$row['addresses_id']}" method="POST">
            <div class="form-group">
              <label for="first_name">first name</label>
              <input name="first_name" type="text" class="form-control" id="fist_name" value="{$row['first_name']}">
            </div>
            <div class="form-group">
              <label for="last_name">Last name</label>
              <input name="last_name" type="text" class="form-control" id="last_name" value="{$row['last_name']}">
            </div>
            <div class="form-group">
              <label for="email_address">Email address</label>
              <input name="email_address" type="email" class="form-control" id="email_address" value="{$row['email_address']}" >
            </div>
            <div class="form-group">
              <label for="telephone_number">telephone number</label>
              <input name="telephone_number" type="text" class="form-control" id="telephone_number" value="{$row['telephone_number']}">
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">gender</label>
              <select name="gender" class="form-control" id="gender">
                <option {$male_select} value='1'>male</option>
                <option {$female_select} value='0'>female</option>
              </select>
            </div>
            <div class="form-group">
              <label for="streetname">streetname</label>
              <input name="streetname" type="text" class="form-control" id="streetname" value="{$row['streetname']}">
            </div>
            <div class="form-group">
              <label for="house_number">house number</label>
              <input name="house_number" type="text" class="form-control" id="house_number" value="{$row['house_number']}">
            </div>
            <div class="form-group">
              <label for="postal_code">postal code</label>
              <input name="postal_code" type="text" class="form-control" id="postal_code" value="{$row['postal_code']}">
            </div>
            <div class="form-group">
              <label for="telephone_number">stater</label>
              <input name="state" type="text" class="form-control" id="state" value="{$row['state']}">
            </div>
            <div class="form-group">
              <label for="city">city</label>
              <input name="city" type="text" class="form-control" id="city" value="{$row['city']}">
            </div>
            <div class="form-group">
              <label for="country">country</label>
              <input name="country" type="text" class="form-control" id="country" value="{$row['country']}">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Submit">
              <a class="btn btn-primary" href="user.php" role="button">back</a>
            </div>
          </form>
</div>
EOT;

require_once(get_document_root() . "/includes/footer.php");
 ?>
