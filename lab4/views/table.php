<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Table</title>
    <link rel="stylesheet" href="https://mahmouddabbous.com/resources/style.css">
</head>

<body>
    <h1>Available items</h1>
    <div class="">
        <form method="get"><label for="search">Search: </label><input type="text" name="search" id="search"></form>
        <a href="https://mahmouddabbous.com/add.php">Add</a>
    </div>
    <table border="2">
        <thead>
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td>Details</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td><a href="https://mahmouddabbous.com?item=<?= $item['id'] ?>">More</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <a href="https://mahmouddabbous.com<?= $page < 1 ? '' : '?page=' . $page - 1  ?>">Prev</a>
        <a href="https://mahmouddabbous.com<?= count($items) < 5 ? '?page=' . $page : '?page=' . $page + 1 ?>">Next</a>
    </div>
</body>

</html>