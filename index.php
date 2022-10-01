<?php

require  __DIR__ . '/vendor/autoload.php';

use App\Entities\Users;
use MatheusSouzaJose\DataMapperOrm\Drivers\MySql;
use MatheusSouzaJose\DataMapperOrm\Repositories\Repository;

$conn = new MySql();
$conn->connect([
    'server' => 'mysql',
    'database' => 'mapper',
    'user' => 'root',
    'password' => 'root',
    'options' => []
]);

$repositories = new Repository($conn);

try {
    $repositories->setEntity(Users::class);
} catch (ReflectionException $e) {
    var_dump($e->getMessage());
}

var_dump($repositories->all());
