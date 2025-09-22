<?php

use Alura\Pdo\Domain\Model\Student;

require 'vendor/autoload.php';

$databasePath = __DIR__ . 'banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$student = new Student(
    null,
    'Stela Marisco Duarte',
    new DateTimeImmutable('2000-12-30')
);

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES(?, ?);";
$statement = $pdo->prepare($sqlInsert);

$statement->bindValue(1, $student->name());
$statement->bindValue(2, $student->birthDate()->format('Y-m-d'));

$resultado = $statement->execute();
var_dump($resultado);

//$sqlInsert = "INSERT INTO students (name, birth_date) VALUES('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}');";

exit();
var_dump($pdo->exec($sqlInsert));