<?php
require_once("../../document_root.php");
require_once(get_document_root() . "/includes/header.php");
get_header('kaasch', '');
require_once(get_document_root() . "/includes/admin_page.php");
require_once(get_document_root() . "/includes/ddb_connect.php");

$user_id = mysqli_real_escape_string($mysqli, $_GET['user_id']);

$result = $mysqli->query("SELECT users.first_name, users.last_name, users.is_admin, users.gender, users.email_address, users.telephone_number, users.addresses_id, addresses.city, addresses.country, addresses.house_number, addresses.postal_code, addresses.state, addresses.streetname FROM users
INNER JOIN addresses ON addresses.id = users.addresses_id WHERE users.id={$user_id}");
$row = $result->fetch_assoc();
$is_admin = '';
if ($row['is_admin'] == true) {
  $is_admin = 'checked';
}
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

          <form class="col-4">
            <div class="form-group">
              <label for="first_name">First Name</label>
              <input disabled type="text" class="form-control" id="fist_name" aria-describedby="first name" value="{$row['first_name']}">
            </div>
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input disabled type="text" class="form-control" id="last_name" value="{$row['last_name']}">
            </div>
            <div class="form-group">
              <label for="email_address">Email Address</label>
              <input disabled type="email" class="form-control" id="email_address" value="{$row['email_address']}" >
            </div>
            <div class="form-group">
              <label for="telephone_number">Telephone Number</label>
              <input disabled type="text" class="form-control" id="telephone_number" value="{$row['telephone_number']}">
            </div>
            <div class="form-check">
              <input disabled type="checkbox" {$is_admin} class="form-check-input" id="is_admin">
              <label class="form-check-label" for="is_admin">Admin</label>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Gender</label>
              <select disabled class="form-control" id="exampleFormControlSelect1">
                <option {$male_select} value='1'>Male</option>
                <option {$female_select} value='0'>Female</option>
              </select>
            </div>
            <div class="form-group">
              <label for="streetname">Street</label>
              <input disabled type="text" class="form-control" id="streetname" value="{$row['streetname']}">
            </div>
            <div class="form-group">
              <label for="house_number">House Number</label>
              <input disabled type="text" class="form-control" id="house_number" value="{$row['house_number']}">
            </div>
            <div class="form-group">
              <label for="postal_code">Postal Code</label>
              <input disabled type="text" class="form-control" id="postal_code" value="{$row['postal_code']}">
            </div>
            <div class="form-group">
              <label for="telephone_number">State</label>
              <input disabled type="text" class="form-control" id="state" value="{$row['state']}">
            </div>
            <div class="form-group">
              <label for="city">City</label>
              <input disabled type="text" class="form-control" id="city" value="{$row['city']}">
            </div>
            <div class="form-group">
              <label for="country">Country</label>
              <input disabled type="text" class="form-control" id="country" value="{$row['country']}">
            </div>
            <div class="form-group">
              <a class="btn btn-primary" href="user_edit.php?user_id={$user_id}" role="button">edit</a>
            </div>
          </form>
</div>
EOT;

require_once(get_document_root() . "/includes/footer.php");
 ?>
