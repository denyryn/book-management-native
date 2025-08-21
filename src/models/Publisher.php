<?php
class Publisher
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM publishers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM publishers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO publishers (name) VALUES (?)");
        $success = $stmt->execute([$data['name']]);
        return $success ? $this->pdo->lastInsertId() : false;
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE publishers SET name = ? WHERE id = ?");
        $success = $stmt->execute([$data['name'], $id]);
        return $success ? $stmt->rowCount() : false;
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM publishers WHERE id = ?");
        $success = $stmt->execute([$id]);
        return $success ? $stmt->rowCount() : false;
    }
}
