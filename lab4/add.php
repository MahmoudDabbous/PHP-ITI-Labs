<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dabbous\Store\Models\Items;

$id = $product_code = $product_name = $list_price = $reorder_level = $units_in_stock = $category = $country = $rating = $discontinued = $date = "";
$photo = "";

function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_code = sanitize_input($_POST["product_code"]);
    $product_name = sanitize_input($_POST["product_name"]);
    $list_price = sanitize_input($_POST["list_price"]);
    $reorder_level = sanitize_input($_POST["reorder_level"]);
    $units_in_stock = sanitize_input($_POST["units_in_stock"]);
    $category = sanitize_input($_POST["category"]);
    $country = sanitize_input($_POST["country"]);
    $rating = sanitize_input($_POST["rating"]);
    $discontinued = isset($_POST["discontinued"]) ? 1 : 0;
    $date = date("Y-m-d");

    if ($_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
        $photo = $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "resources/images/" . $photo);
    }

    if (empty($product_code)) {
        $errors[] = "Product code is required.";
    }

    if (empty($product_name)) {
        $errors[] = "Product name is required.";
    }

    if (empty($list_price)) {
        $errors[] = "List price is required.";
    } elseif (!is_numeric($list_price)) {
        $errors[] = "List price must be a numeric value.";
    }

    if (empty($reorder_level)) {
        $errors[] = "Reorder level is required.";
    } elseif (!ctype_digit($reorder_level)) {
        $errors[] = "Reorder level must be a positive integer.";
    }

    if (empty($units_in_stock)) {
        $errors[] = "Units in stock is required.";
    } elseif (!ctype_digit($units_in_stock)) {
        $errors[] = "Units in stock must be a positive integer.";
    }

    if (empty($category)) {
        $errors[] = "Category is required.";
    }

    if (empty($country)) {
        $errors[] = "Country is required.";
    }

    if (empty($rating)) {
        $errors[] = "Rating is required.";
    } elseif (!is_numeric($rating) || $rating < 0 || $rating > 5) {
        $errors[] = "Rating must be a numeric value between 0 and 5.";
    }

    if (!empty($discontinued) && $discontinued != 0 && $discontinued != 1) {
        $errors[] = "Invalid value for discontinued.";
    }

    if (empty($errors)) {
        $item = new Items;

        $item->product_code = $product_code;
        $item->product_name = $product_name;
        $item->photo = $photo;
        $item->list_price = $list_price;
        $item->reorder_level = $reorder_level;
        $item->units_in_stock = $units_in_stock;
        $item->category = $category;
        $item->rating = $rating;
        $item->date = $date;
        $item->discontinued = $discontinued;

        try {
            $item->save();
        } catch (\Exception $th) {
            echo "Error saving item: " . $th->getMessage();
        }

        header('Location: https://mahmouddabbous.com');
        exit();
    }
}

require_once __DIR__ . '/views/add.php';
