<?php

use Alura\Pdo\Domain\Model\Student;

require 'vendor/autoload.php';

$databasePath = __DIR__ . 'banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath); // Novo objeto da classe PDO

$statement = $pdo->query('SELECT * FROM students'); //retorna um array de objetos da classe PDOStatement

var_dump($statement->fetchAll(PDO::FETCH_CLASS), Student::class);