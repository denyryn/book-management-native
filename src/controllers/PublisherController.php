<?php
require_once __DIR__ . '/../models/Publisher.php';

class PublisherController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Publisher($pdo);
    }

    public function index()
    {
        return $this->model->all();
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function store($data)
    {
        try {
            if (empty($data['name'])) {
                return ['success' => false, 'error' => 'Name is required'];
            }

            $id = $this->model->create($data);

            return $id
                ? ['success' => true, 'id' => $id]
                : ['success' => false, 'error' => 'Failed to create publisher'];

        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function update($id, $data)
    {
        try {
            if (empty($data['name'])) {
                return ['success' => false, 'error' => 'Name is required'];
            }

            $rows = $this->model->update($id, $data);

            return [
                'success' => $rows !== false,
                'affected_rows' => $rows
            ];

        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $rows = $this->model->delete($id);

            return [
                'success' => $rows !== false,
                'affected_rows' => $rows
            ];

        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
