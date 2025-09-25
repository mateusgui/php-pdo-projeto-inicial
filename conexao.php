<?php

require 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$pdo = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($pdo);

//$student = new Student(null, 'Patricia Guimarães', new DateTimeImmutable('1990-08-01'));
//$repository->save($student);

$sqlQuery = "INSERT INTO phones (area_code, number, student_id) VALUES ('67', '999999999', 2)";
$pdo->exec($sqlQuery);

var_dump($repository->allWithPhones());