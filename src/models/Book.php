<?php
class Book
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT b.*, c.name AS category_name, a.name AS author_name, p.name AS publisher_name FROM books b LEFT JOIN categories c ON b.category_id = c.id LEFT JOIN authors a ON b.author_id = a.id LEFT JOIN publishers p ON b.publisher_id = p.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($params)
    {
        $sql = "SELECT b.*, c.name AS category_name, a.name AS author_name, p.name AS publisher_name
            FROM books b
            LEFT JOIN categories c ON b.category_id = c.id
            LEFT JOIN authors a ON b.author_id = a.id
            LEFT JOIN publishers p ON b.publisher_id = p.id
            WHERE 1=1"; // Always true so we can safely append ANDs

        $values = [];

        if (!empty($params['search'])) {
            $sql .= " AND (b.title LIKE :search OR c.name LIKE :search OR a.name LIKE :search OR p.name LIKE :search)";
            $values[':search'] = '%' . $params['search'] . '%';
        }

        if (!empty($params['category'])) {
            $sql .= " AND b.category_id = :category";
            $values[':category'] = $params['category'];
        }

        if (!empty($params['author'])) {
            $sql .= " AND b.author_id = :author";
            $values[':author'] = $params['author'];
        }

        if (!empty($params['publisher'])) {
            $sql .= " AND b.publisher_id = :publisher";
            $values[':publisher'] = $params['publisher'];
        }

        if (!empty($params['start_date'])) {
            $sql .= " AND b.publication_date >= :start_date";
            $values[':start_date'] = $params['start_date'];
        }

        if (!empty($params['end_date'])) {
            $sql .= " AND b.publication_date <= :end_date";
            $values[':end_date'] = $params['end_date'];
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO books (category_id, author_id, publisher_id, title, publication_date, number_of_pages) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['category_id'], $data['author_id'], $data['publisher_id'], $data['title'], $data['publication_date'], $data['number_of_pages']]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE books SET title = ?, author_id = ?, publisher_id = ?, publication_date = ?, number_of_pages = ? WHERE id = ?");
        $stmt->execute([$data['title'], $data['author_id'], $data['publisher_id'], $data['publication_date'], $data['number_of_pages'], $id]);
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
