<?php

use Alura\Pdo\Domain\Model\Student;

require 'vendor/autoload.php';

$databasePath = __DIR__ . 'banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$student = new Student(
    null,
    'teste',
    new DateTimeImmutable('2011-08-12')
);

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES(:name, :birth_date);";
$statement = $pdo->prepare($sqlInsert);

$statement->bindValue(':name', $student->name());
$statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));

$resultado = $statement->execute(); //retorna um Bool
var_dump($resultado);

$pdo = null;

//$sqlInsert = "INSERT INTO students (name, birth_date) VALUES('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}');";
//var_dump($pdo->exec($sqlInsert));
