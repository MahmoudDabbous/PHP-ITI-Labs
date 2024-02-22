<?php
require_once './config.php';

$name = $email = $phone = $message = "";
$success = false;
$err = [];

function clean_input(string $input): string
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function validate_alpha(string $string, int $min = 4, int $max = 50, bool $allows_numbers = false): bool
{
    if ($allows_numbers) {
        $regex = "/^[a-zA-Z0-9 ]{$min},{$max}}$/";
    } else {
        $regex = "/^[a-zA-Z ]{{$min},{$max}}$/";
    }
    return preg_match($regex, $string);
}

function validate_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone(string $phone): bool
{
    return preg_match("/^[0-9]{11}$/", $phone);
}

function display_error(string $key, array $err): string
{
    return isset($err[$key]) ? htmlspecialchars($err[$key]) : '';
}

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
        $err['phone'] = "Invalid phone number";
    }

    if (empty($message)) {
        $err['message'] = "Message is required";
    } elseif (!validate_alpha($message, max: MAX_MESSAGE_LENGTH, allows_numbers: true)) {
        $err['message'] = "Message must be 4 to 3000 letters long and contain alphanumeric characters only";
    }

    if (empty($err)) {
        $success = true;
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
    <?php if ($success) : ?>
        <div id="after_submit">
            <p>Thank you! Your message has been sent successfully.</p>
        </div>
    <?php endif; ?>
    <div>
        <?php if (!empty($err)) : ?>
            <ul>
                <?php foreach ($err as $error) : ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
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