<?php

require 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$studentList = $studentRepository->all();

foreach ($studentList as $student) {
    echo "Nome: " . $student->name() . " Id: " . $student->id() . " Data de Nascimento: " . $student->birthDate()->format('Y-m-d') . " Idade: " . $student->age() . "\n";
}

var_dump($studentList);