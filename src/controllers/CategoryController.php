<?php
require_once __DIR__ . '/../Models/Category.php';

class CategoryController
{
    private $category;

    public function __construct($pdo)
    {
        $this->category = new Category($pdo);
    }

    public function index()
    {
        return $this->category->all();
    }

    public function show($id)
    {
        return $this->category->find($id);
    }

    public function showBySlug($slug)
    {
        return $this->category->findBySlug($slug);
    }

    public function store($data)
    {
        try {
            if (empty($data['name'])) {
                return ['success' => false, 'error' => 'Name is required'];
            }

            $slug = !empty($data['slug']) ? $data['slug'] : $this->generateSlug($data['name']);
            $id = $this->category->create($data['name'], $slug);

            return ['success' => true, 'id' => $id];
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

            $slug = !empty($data['slug']) ? $data['slug'] : $this->generateSlug($data['name']);
            $affected = $this->category->update($id, $data['name'], $slug);

            return ['success' => $affected > 0, 'affected_rows' => $affected];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $affected = $this->category->delete($id);
            return ['success' => $affected > 0, 'affected_rows' => $affected];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function generateSlug($string)
    {
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace('/-+/', '-', $slug);
        return $slug;
    }
}
