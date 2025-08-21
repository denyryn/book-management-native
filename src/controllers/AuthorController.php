<?php
require_once __DIR__ . '/../models/Author.php';

class AuthorController
{
    private $author;

    public function __construct($pdo)
    {
        $this->author = new Author($pdo);
    }

    public function index()
    {
        return $this->author->all();
    }

    public function show($id)
    {
        return $this->author->find($id);
    }

    public function store($data)
    {
        try {
            $id = $this->author->create($data);
            return ['success' => true, 'id' => $id];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function update($id, $data)
    {
        try {
            $affected = $this->author->update($id, $data);
            return ['success' => $affected > 0, 'affected_rows' => $affected];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $affected = $this->author->delete($id);
            return ['success' => $affected > 0, 'affected_rows' => $affected];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
