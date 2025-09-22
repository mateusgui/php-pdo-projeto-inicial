<?php

use Alura\Pdo\Domain\Model\Student;

require 'vendor/autoload.php';

$databasePath = __DIR__ . 'banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath); // Novo objeto da classe PDO

$statement = $pdo->query('SELECT * FROM students'); //retorna um objeto da classe PDOStatement

while($studentData = $statement->fetch(PDO::FETCH_ASSOC)){ //Vai permanecer true enquanto existirem registros sendo retornados
    $student = new Student($studentData['id'], $studentData['name'], new DateTimeImmutable($studentData['birth_date']));

    echo $student->name() . ":" . $student->id() . "\n";
}

$pdo = null;

//var_dump($listaDeAlunos);