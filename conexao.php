<?php

$databasePath = __DIR__ . 'banco.sqlite';

$pdo = new PDO('sqlite:' . $caminhoBanco);

echo 'conectei';

$pdo->exec(
    'CREATE TABLE students (
    id INTEGER PRIMARY KEY,
    name TEXT,
    birth_date TEXT
    );');