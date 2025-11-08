<?php

namespace TaskCli;

use Exception;
use PDO;

class Model
{
    private string $filePath;
    private PDO $pdo;

    public function __construct()
    {
        date_default_timezone_set("America/Sao_Paulo");

        $this->filePath = dirname(__DIR__, 2) . "/database.sqlite";
        if (!file_exists($this->filePath)) {
            $file = fopen($this->filePath, "w");
            fclose($file);
        }

        $this->setup();
    }

    public function setup()
    {
        $this->pdo = new PDO("sqlite:$this->filePath", null, null, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("PRAGMA foreign_keys = ON;");
        $this->pdo->exec(<<<TEXT
            CREATE TABLE IF NOT EXISTS status (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL UNIQUE
            );
        TEXT);
        $this->pdo->exec(<<<TEXT
             INSERT OR IGNORE INTO status (name)
             VALUES ('todo'), ('done'), ('in-progress');
        TEXT);
        $this->pdo->exec(<<<TEXT
            CREATE TABLE IF NOT EXISTS tasks (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                updated_at TEXT NOT NULL,
                created_at TEXT NOT NULL,
                description TEXT NOT NULL,
                status_id INTEGER DEFAULT 1,
                FOREIGN KEY (status_id) REFERENCES status (id));
        TEXT);
    }

    public function save(Task $task): void
    {
        $stmt = $this->pdo->prepare(<<<TEXT
            INSERT INTO tasks (description, created_at, updated_at)
            VALUES (:description, :created, :updated);
        TEXT);
        $stmt->bindParam(":created", $task->createdAt);
        $stmt->bindParam(":updated", $task->updatedAt);
        $stmt->bindParam(":description", $task->description);
        $stmt->execute();
    }

    public function listAll(): array
    {
        $stmt = $this->pdo->query(<<<TEXT
            SELECT tasks.id, tasks.description, status.name
            FROM tasks
            INNER JOIN status
            ON tasks.status_id = status.id;
        TEXT);
        return $stmt->fetchAll();
    }

    public function listByStatus(string $status): array
    {
        $status = $this->getStatusByName($status);

        $stmt = $this->pdo->prepare(<<<TEXT
            SELECT tasks.id, tasks.description, status.name
            FROM tasks
            INNER JOIN status
            ON tasks.status_id = status.id
            WHERE tasks.status_id=:statusId;
        TEXT);
        $stmt->bindParam(":statusId", $status->id);
        $stmt->execute();
        $tasks = $stmt->fetchAll();

        return $tasks;
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id=:id;");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function update(int $id, string $description): void
    {
        $stmt = $this->pdo->prepare("UPDATE tasks SET description=:description, updated_at=:updated WHERE id=:id;");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":description", $description);
        $stmt->bindValue(":updated", date("Y-m-d H-i-s"));
        $stmt->execute();
    }

    public function setStatus(int $id, string $status): void
    {
        $status = $this->getStatusByName($status);

        $stmt = $this->pdo->prepare("UPDATE tasks SET status_id=:statusId, updated_at=:updated WHERE id=:id;");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":statusId", $status->id);
        $stmt->bindValue(":updated", date("Y-m-d H-i-s"));
        $stmt->execute();
    }

    public function getStatusByName(string $status): object
    {
        $stmt = $this->pdo->prepare("SELECT id FROM status WHERE name=:statusName;");
        $stmt->bindParam(":statusName", $status);
        $stmt->execute();
        $status = $stmt->fetch();
        if (!$status) {
            throw new Exception("Status not found");
        }
        return $status;
    }

    function getStatusById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT description FROM status WHERE id=:id;");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
