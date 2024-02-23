<?php

require_once __DIR__ . '/vendor/autoload.php';

$name = $email = $phone = $message = "";
$success = false;
$err = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = clean_input($_POST["name"]);
    $email = clean_input($_POST["email"]);
    $phone = clean_input($_POST["phone"]);
    $message = clean_input($_POST["message"]);

    if (empty($name)) {
        $err['name'] = "Name is required";
    } elseif (!validate_alpha($name, max: MAX_NAME_LENGTH)) {
        $err['name'] = "Name must be 4 to 120 letters long and contain only letters and whitespaces";
    }

    if (empty($email)) {
        $err['email'] = "Email is required";
    } elseif (!validate_email($email)) {
        $err['email'] = "Invalid email format";
    }

    if (empty($phone)) {
        $err['phone'] = "Phone number is required";
    } elseif (!validate_phone($phone)) {
        $err['phone'] = "Invalid phone number, It must start with 0 and be 11 numbers long";
    }

    if (empty($message)) {
        $err['message'] = "Message is required";
    } elseif (!validate_alpha($message, max: MAX_MESSAGE_LENGTH, allows_numbers: true)) {
        $err['message'] = "Message must be 4 to 3000 letters long and contain alphanumeric characters only";
    }

    if (empty($err)) {
        session_start();
        $_SESSION = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message
        ];
        log_form_submission($name, $email);
        header("location: ./success.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>

<body>
    <h3>Contact Form</h3>
    <?php if (!empty($err)) : ?>
        <div>
            <ul>
                <?php foreach ($err as $error) : ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form id="contact_form" method="POST" enctype="multipart/form-data">
        <div class="row">
            <label class="required" for="name">Your name:</label><br />
            <input id="name" class="input" name="name" type="text" value="<?= htmlspecialchars($name); ?>" size="30" /><br />
        </div>
        <div class="row">
            <label class="required" for="email">Your email:</label><br />
            <input id="email" class="input" name="email" type="text" value="<?= htmlspecialchars($email); ?>" size="30" /><br />
        </div>
        <div class="row">
            <label class="required" for="phone">Your phone:</label><br />
            <input id="phone" class="input" name="phone" type="text" value="<?= htmlspecialchars($phone); ?>" size="30" /><br />
        </div>
        <div class="row">
            <label class="required" for="message">Your message:</label><br />
            <textarea id="message" class="input" name="message" rows="7" cols="30"><?= htmlspecialchars($message); ?></textarea><br />
        </div>
        <input id="submit" name="submit" type="submit" value="Send email" />
        <input id="clear" name="clear" type="reset" value="Clear form" />
    </form>
</body>

</html>