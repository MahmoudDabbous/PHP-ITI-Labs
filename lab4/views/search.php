<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Table</title>
    <link rel="stylesheet" href="./resources/style.css">
</head>

<body>
    <h1>Search Result</h1>
    <div class="">
        <a href="./">Back</a>
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
            <?php foreach ($search_results as $item) : ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td><a href="./?item=<?= $item['id'] ?>">More</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <a href="./?search=<?= $search_query ?><?= $page < 1 ? '' : '&page=' . $page - 1  ?>">Prev</a>
        <a href="./?search=<?= $search_query ?><?= count($search_results) < 5 ? '&page=' . $page  : '&page=' . $page + 1 ?>">Next</a>
    </div>
</body>

</html>