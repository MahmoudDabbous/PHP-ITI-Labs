<?php

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
        $regex = "/^[a-zA-Z0-9 ]{{$min},{$max}}$/";
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
    return preg_match("/^0[0-9]{10}$/", $phone);
}

function display_error(string $key, array $err): string
{
    return isset($err[$key]) ? htmlspecialchars($err[$key]) : '';
}

function log_form_submission(string $name, string $email)
{
    $logData = date("F j Y g:i a") . " | " . $_SERVER['REMOTE_ADDR'] . " | $email | $name" . PHP_EOL;
    $file = fopen(LOG_FILE, "a");
    fwrite($file, $logData);
    fclose($file);
}
