<?php
require_once("../document_root.php");
$relative_path = get_relative_root();

session_start();
if (isset($_SESSION)) {
  session_destroy();
  header("Location: {$relative_path}/index.php");
} else {
  echo "no session";
}

 ?>
