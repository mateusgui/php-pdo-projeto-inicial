<?php

require 'vendor/autoload.php';

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$pdo->exec("INSERT INTO phones (area_code, number, student_id) VALUES ('67', '99140-4154', 1), ('67', '99194-9429', 2);");
exit();

$createTableSql = '
    CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY,
        name TEXT,
        birth_date TEXT
    );

    CREATE TABLE IF NOT EXISTS phones (
        id INTEGER PRIMARY KEY,
        area_code TEXT,
        number TEXT,
        student_id INTEGER,
        FOREIGN KEY (student_id) REFERENCES students(id)
    );
';

$pdo->exec($createTableSql);