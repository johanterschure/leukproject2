<?php
require_once("../../document_root.php");
require_once(get_document_root() . "/includes/header.php");
get_header('kaasch', '');
require_once(get_document_root() . "/includes/admin_page.php");
require_once(get_document_root() . "/includes/ddb_connect.php");

$result = $mysqli->query(	"SELECT id, first_name, last_name, email_address FROM users");

echo '<div class="container">
        <div class="row">
            <div class="col-12">
                <h1>gebruikers</h1>
            </div>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">e-mail</th>
                <th scope="col">Show user</th>
                <th scope="col">View orders</th>
              </tr>
            </thead>
            <tbody>';

foreach($result as $row) {
    echo " <tr>
      <th scope='row'>{$row['id']}</th>
      <td>{$row['first_name']}</td>
      <td>{$row['last_name']}</td>
      <td>{$row['email_address']}</td>
      <td>
        <a href='{$relative_path}/pages/admin/user.php?user_id={$row['id']}'>show user</a>
      </td>
      <td>
        <a href='{$relative_path}/pages/admin/account_order_overview.php?user_id={$row['id']}'>Orders</a>
    </tr>";
}

echo '</tbody>
    </table>';



require_once(get_document_root() . "/includes/footer.php");
 ?>
