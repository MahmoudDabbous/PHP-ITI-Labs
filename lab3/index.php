<?php

require_once 'vendor/autoload.php';

use Dabbous\Lab3\Counter;
use Dabbous\Lab3\Visitor;

$counter = new Counter();

if (!Visitor::isActive()) {
    $counter->incrementCount();
}

echo "Number of Visits: {$counter->getCount()}";
