<?php

namespace Dabbous\Lab3;

class Visitor
{
    public static function isActive(): bool
    {
        session_start();
        if (!isset($_SESSION['is_counted'])) {
            $_SESSION['is_counted'] = true;
            return false;
        }
        return true;
    }
}
