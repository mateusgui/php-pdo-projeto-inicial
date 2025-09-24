<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;
use PDOStatement;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection) //Injeção de dependência
    {
        $this->connection = $connection; //Já recebe a conexão pronta, então pode receber conexão de qualquer tipo de banco
    }

    public function all(): array
    {
        $stmt = $this->connection->query('SELECT * FROM students');
        return $this->hydrateStudentList($stmt);
    }

    public function studentsBirthAt(DateTimeInterface $birthDate): array
    {
        $sqlQuery = "SELECT * FROM students WHERE birth_date = :birthDate;";
        $stmt = $this->connection->prepare($sqlQuery);

        $stmt->bindValue(':birthDate', $birthDate->format('Y-m-d'));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    public function save(Student $student): bool
    {
        if($student->id() === null){
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function remove(Student $student): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM students WHERE id = ?');
        $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    private function insert(Student $student): bool
    {
        $insertQuery = 'INSERT INTO students (name, birth_date) VALUES(:name, :birth_date);';
        $stmt = $this->connection->prepare($insertQuery);

        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));

        return $stmt->execute();
    }

    private function update(Student $student): bool
    {
        $updateQuery = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $stmt = $this->connection->prepare($updateQuery);

        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue('birth_Date', $student->birthDate()->format('Y-m-d'));
        $stmt->bindValue('id', $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    private function hydrateStudentList(PDOStatement $stmt): array
    {
        $studentsList = [];

    /**
     * Transforma um resultado de consulta PDO (PDOStatement) em um array de objetos Student.
     *
     * @param PDOStatement $stmt O resultado da consulta PDO pronta para ser percorrida.
     * @return Student[] Um array de objetos da classe Student.
     */
        while($studentData = $stmt->fetch(PDO::FETCH_ASSOC)){
            $studentsList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable ($studentData['birth_date'])
            );
        }

        return $studentsList;
    }
}