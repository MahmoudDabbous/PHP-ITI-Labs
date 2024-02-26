<?php

require_once 'vendor/autoload.php';

use Dabbous\Lab3\Counter;
use Dabbous\Lab3\Visitor;

$countFilePath = VISITS_LOG;
$counter = new Counter($countFilePath);

if (!Visitor::isActive()) {
    $counter->incrementCount();
}

echo "Number of Visits: {$counter->getCount()}";
