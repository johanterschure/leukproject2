<?php
function connect_db() {
  $mysqli = new mysqli("stevenik.nl", "kaasbeheer", "kaas123", "kaasch");
  if ($mysqli->connect_errno) {
      return "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  return $mysqli;

}
$mysqli = connect_db();
?>
