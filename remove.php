<?php

require 'vendor/autoload.php';

$databasePath = __DIR__ . 'banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath); // Novo objeto da classe PDO

$sqlDelete = 'DELETE FROM students WHERE ID = ?;';
$preparedStatement = $pdo->prepare('DELETE FROM students WHERE ID = ?;');
$preparedStatement->bindValue(1, 5, PDO::PARAM_INT);
var_dump($preparedStatement->execute());