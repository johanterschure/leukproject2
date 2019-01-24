<?php
    session_start();
    require_once("../../document_root.php");
    require_once(get_document_root() . '/includes/ddb_connect.php');

    if(isset($_POST["discount"])) {
        if(isset($_POST["discount_code"])) {
            $discount_code = mysqli_real_escape_string($mysqli, $_POST['discount_code']);
            $result = $mysqli->query("SELECT * FROM discount_codes WHERE code = '{$discount_code}';");

            if (mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                $_SESSION["shopping_cart_discount"] = $row["discount_percentage"];
            }
        }
    }
    header("Location: " . get_relative_root() . "/pages/shopping_cart");
?>