<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();

try {

    $student = new Student(
        1,
        'Nico',
        new DateTimeImmutable('2000-05-13')
    );
    echo $studentRepository->save($student);

    $otherStudent = new Student(
        2,
        'Sergio',
        new DateTimeImmutable('2011-08-12')
    );
    echo $studentRepository->save($otherStudent);

    $connection->commit();
    
} catch (PDOException $e) {

    echo $e->getMessage();
    $connection->rollBack();

}