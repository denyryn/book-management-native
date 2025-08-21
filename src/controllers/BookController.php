<?php
require_once __DIR__ . '/../models/Book.php';

class BookController
{
    private $book;

    public function __construct($pdo)
    {
        $this->book = new Book($pdo);
    }

    public function index()
    {
        return $this->book->all();
    }

    public function search($queryParams)
    {
        return $this->book->search($queryParams);
    }

    public function show($id)
    {
        return $this->book->find($id);
    }

    public function store($data)
    {
        try {
            $id = $this->book->create($data);
            return ['success' => true, 'id' => $id];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function update($id, $data)
    {
        try {
            $affected = $this->book->update($id, $data);
            return ['success' => $affected > 0, 'affected_rows' => $affected];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $affected = $this->book->delete($id);
            return ['success' => $affected > 0, 'affected_rows' => $affected];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
