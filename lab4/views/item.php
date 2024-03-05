<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/style.css">
    <title><?= $item['product_name'] ?></title>
</head>

<body>
    <table border="2">
        <thead>
            <tr>
                <td>Type: <?= $item['product_name'] ?></td>
                <td>Price: <?= $item['list_price'] ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <ul>
                        <li>Code: <?= $item['product_code'] ?></li>
                        <li>Id: <?= $item['id'] ?></li>
                        <li>Rating: <?= $item['rating'] ?></li>
                    </ul>
                </td>
                <td>
                    <img src="./<?= IMAGE_STORAGE_URI . $item['Photo'] ?>" alt="">
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>