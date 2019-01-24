<?php
if(session_id() == '') {
  session_start();
}
$relative_path = get_relative_root();
if (!$_SESSION['is_admin']) {
  header("location: {$relative_path}/index.php");
}
echo "
<div id='sidebar-wrapper'>
  <ul class='sidebar-nav'>
    <li class='sidebar-brand'>
    </li>
    <li>
      <a href='{$relative_path}/pages/admin/users.php'>Users</a>
    </li>
    <li>
      <a href='#'>Contact</a>
    </li>
  </ul>
</div>
";
?>
