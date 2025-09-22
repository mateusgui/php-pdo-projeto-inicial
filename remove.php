<?php

require 'vendor/autoload.php';

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
$pdo = ConnectionCreator::createConnection();

$sqlDelete = 'DELETE FROM students WHERE ID = ?;';
$preparedStatement = $pdo->prepare('DELETE FROM students WHERE ID = ?;');
$preparedStatement->bindValue(1, 5, PDO::PARAM_INT);
var_dump($preparedStatement->execute());