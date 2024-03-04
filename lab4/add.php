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

        $item->save();

        header('Location: https://mahmouddabbous.com');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Item Form</title>
    <link rel="stylesheet" href="https://mahmouddabbous.com/resources/style.css">
</head>

<body>
    <h2>Create Item</h2>
    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="product_code">Product Code:</label><br>
        <input type="text" id="product_code" name="product_code" required><br>

        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" required><br>

        <label for="photo">Photo:</label><br>
        <input type="file" id="photo" name="photo" required><br>

        <label for="list_price">List Price:</label><br>
        <input type="text" id="list_price" name="list_price" required><br>

        <label for="reorder_level">Reorder Level:</label><br>
        <input type="text" id="reorder_level" name="reorder_level" required><br>

        <label for="units_in_stock">Units in Stock:</label><br>
        <input type="text" id="units_in_stock" name="units_in_stock" required><br>

        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" required><br>

        <label for="country">Country:</label><br>
        <input type="text" id="country" name="country" required><br>

        <label for="rating">Rating:</label><br>
        <input type="text" id="rating" name="rating" required><br>

        <label for="discontinued">Discontinued:</label>
        <input type="checkbox" id="discontinued" name="discontinued"><br>

        <input type="submit" value="submit">
    </form>
</body>

</html>