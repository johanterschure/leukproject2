<?php
    require_once("../../../document_root.php");
    require_once(get_document_root() . '/includes/ddb_connect.php');
    session_start();

    if(isset($_POST["Submit"])) {
        $is_anonymous = false;

        if(isset($_POST["anomymous"])) {
            $is_anonymous = true;
        }

        $user_id = mysqli_real_escape_string($mysqli, $_SESSION["user_id"]);
        $score = mysqli_real_escape_string($mysqli, $_POST["score"]);
        $content = mysqli_real_escape_string($mysqli, $_POST["content"]);
        $product_id = mysqli_real_escape_string($mysqli, $_POST["product_id"]);
        // $is_anonymous = mysqli_real_escape_string($mysqli, isset($_POST["is_anonymous"])); -- Does not work?
        if (isset($_POST["is_anonymous"])) {
            $is_anonymous = mysqli_real_escape_string($mysqli, "true");
        } else {
            $is_anonymous = mysqli_real_escape_string($mysqli, "false");
        }
        
        $mysqli->query("INSERT INTO reviews (products_id, users_id, content, score, is_anonymous) VALUES ({$product_id}, {$user_id}, '{$content}', {$score}, {$is_anonymous});");
        header("Location: " . get_relative_root() . "/pages/product/product.php?id={$product_id}");
    } else {
        header("Location: ");
    }


?>