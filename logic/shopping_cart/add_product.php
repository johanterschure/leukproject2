<?php
    require_once("../../document_root.php");
    require_once(get_document_root() . '/includes/ddb_connect.php');
    session_start();

    /// Add a product to the shopping cart by post
    /// call the post with product_id and return_url as post values

    if (isset($_POST[strtolower("submit")]))  {
        if (isset($_POST["product_id"])) {
            $id = $_POST["product_id"];
            $shoppingcart = $_SESSION["shoppingcart"];
            
            $productIsInCart = false;
            $productIsInCartIndex = 0;
            
            for($i = 0; $i < sizeof($shoppingcart); $i++ ){
                if($shoppingcart[$i][0] == $id) {
                    $productIsInCart = true;
                    $productIsInCartIndex = $i;
                }
            }

            if ($productIsInCart) {
                $shoppingcart[$productIsInCartIndex][1] += 1;
            } else {
                $shoppingcart[] = array($id, 1);
            }

            $_SESSION["shoppingcart"] = $shoppingcart;

            if (isset($_POST["return_url"])) {
                if ($_POST["return_url"] != "") {
                    header("Location: " . get_relative_root() . $_POST["return_url"]);
                    exit;
                } 
            } 
           header("Location: " . get_relative_root());
        }
    }
?>