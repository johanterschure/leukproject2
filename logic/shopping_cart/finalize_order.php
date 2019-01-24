<?php
    require_once("../../document_root.php");
    require_once(get_document_root() . '/includes/ddb_connect.php');
    require_once(get_document_root() . "/includes/header.php");
    if (!login_check()) {
        header("Location: " . get_relative_root() . "/pages/shopping_cart");
    }

    if(isset($_POST["Submit"])) {
        if(isset($_POST["useDefault"])) {
            $user_id = mysqli_real_escape_string($mysqli, $_SESSION["user_id"]);

            $result = $mysqli->query("SELECT addresses_id FROM users WHERE id = {$user_id};");

            if (mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                create_order($mysqli, $row["addresses_id"]);
            }
        } elseif ($_POST["street_name"] != "" && $_POST["house_number"] != "" && $_POST["city"] != "" && $_POST["postal_code"] != "" && $_POST["state"] != "" && $_POST["country"] != "") {
            $street_name =  mysqli_real_escape_string($mysqli, $_POST["street_name"]);
            $house_number =  mysqli_real_escape_string($mysqli, $_POST["house_number"]);
            $city =  mysqli_real_escape_string($mysqli, $_POST["city"]);
            $postal_code =  mysqli_real_escape_string($mysqli, $_POST["postal_code"]);
            $state =  mysqli_real_escape_string($mysqli, $_POST["state"]);
            $country =  mysqli_real_escape_string($mysqli, $_POST["country"]);

            $mysqli->query("INSERT INTO addresses (streetname, house_number, city, postal_code, state, country) VALUES ({$street_name}, {$house_number}, {$city}, {$postal_code}, {$state}, {$country});");
            create_order($mysqli, $mysqli->insert_id);
        } else {
            header("Location: finalize_order.php");
        }
    } else {
        header("Location: finalize_order.php");
    }

    function create_order($mysqli, $addresses_id) {
        $user_id = mysqli_real_escape_string($mysqli, $_SESSION["user_id"]);

        // Status starts at 1
        // Payment method can't be null. Default to 1


        $mysqli->query("INSERT INTO orders (users_id, date, status_id, paymentmethods_id, is_paid, addresses_id) VALUES ({$user_id}, NOW(), 1, 1, 0, {$addresses_id});");
        $order_id = $mysqli->insert_id;

        foreach($_SESSION["shoppingcart"] as $cart) {
            $product_id = mysqli_real_escape_string($mysqli, $cart[0]);
            $amount = mysqli_real_escape_string($mysqli, $cart[1]);

            $mysqli->query("INSERT INTO orders_has_products (orders_id, products_id, amount) VALUES ({$order_id}, {$product_id}, {$amount});");
        }

        header("Location: " . get_relative_root() . "/pages/shopping_cart/payment_selection.php?orderid={$order_id}");
    }
?>
