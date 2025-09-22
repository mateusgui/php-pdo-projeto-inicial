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
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectionCreator::createConnection();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM students');
        return $this->hydrateStudentList($stmt);
    }

    public function studentsBirthAt(DateTimeInterface $birthDate): array
    {
        $sqlQuery = "SELECT * FROM students WHERE birth_date = :birthDate;";
        $stmt = $this->pdo->prepare($sqlQuery);

        $stmt->bindValue(':birthDate', $birthDate->format('Y-m-d'));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    private function hydrateStudentList(PDOStatement $stmt): array
    {
        $studentsList = [];

        while($studentData = $stmt->fetch(PDO::FETCH_ASSOC)){
            $studentsList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable ($studentData['birth_date'])
            );
        }

        return $studentsList;
    }

    public function save(Student $student): bool
    {
        if($student->id() === null){
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $insertQuery = 'INSERT INTO students (name, birth_date) VALUES(:name, :birth_date);';
        $stmt = $this->pdo->prepare($insertQuery);

        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue(':birthDate', $student->birthDate());

        return $stmt->execute();
    }

    private function update(Student $student): bool
    {
        $updateQuery = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $stmt = $this->pdo->prepare($updateQuery);

        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue('birth_Date', $student->birthDate()->format('Y-m-d'));
        $stmt->bindValue('id', $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function remove(Student $student): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM students WHERE id = ?');
        $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }
}