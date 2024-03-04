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
    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
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