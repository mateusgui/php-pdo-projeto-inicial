<?php

require 'vendor/autoload.php';

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
$pdo = ConnectionCreator::createConnection();

echo 'conectei';

$pdo->exec(
    'CREATE TABLE students (
    id INTEGER PRIMARY KEY,
    name TEXT,
    birth_date TEXT
    );');