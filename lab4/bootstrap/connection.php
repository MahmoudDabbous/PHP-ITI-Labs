<?php

use Illuminate\Database\Capsule\Manager;


try {
    $mgr = new Manager;

    $mgr->addConnection([
        "driver" => 'mysql',
        "host" => MYSQL_HOST,
        "database" => MYSQL_DB,
        "username" => MYSQL_USER,
        "password" => MYSQL_PASS,
    ]);

    $mgr->setAsGlobal();
    $mgr->bootEloquent();
} catch (\Exception $ex) {
    echo "<h1>Error, Please contact administrator: </h1>";
    echo "<pre>";
    print_r($ex->getMessage());
    echo "</pre>";
    die();
}
