<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://mahmouddabbous.com/resources/style.css">
    <title><?= $item_data['product_name'] ?></title>
</head>

<body>
    <table border="2">
        <thead>
            <tr>
                <td>Type: <?= $item_data['product_name'] ?></td>
                <td>Price: <?= $item_data['list_price'] ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <ul>
                        <li>Code: <?= $item_data['product_code'] ?></li>
                        <li>Id: <?= $item_data['id'] ?></li>
                        <li>Rating: <?= $item_data['rating'] ?></li>
                    </ul>
                </td>
                <td>
                    <img src="<?= IMAGE_STORAGE_URI . $item_data['Photo'] ?>" alt="">
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>