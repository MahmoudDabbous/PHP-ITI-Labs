<?php

session_start();

if (empty($_SESSION['name']) || empty($_SESSION['email']) || empty($_SESSION['phone']) || empty($_SESSION['message'])) {
    header("Location: ./");
    exit;
}

$name = $_SESSION['name'];
$logData = @file_get_contents('log.txt');
$logLines = explode(PHP_EOL, $logData);

session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Data</title>
</head>

<body>
    <h1>Thank you for contacting us <?= htmlspecialchars($name) ?></h1>
    <h3>Log Data</h3>
    <?php if ($logLines) : ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>IP Address</th>
                    <th>Email</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logLines as $line) : ?>
                    <?php $fields = explode(" | ", $line); ?>
                    <tr>
                        <?php foreach ($fields as $field) : ?>
                            <td><?= htmlspecialchars($field); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <h1>Error Getting the logs</h1>
    <?php endif ?>
</body>

</html>