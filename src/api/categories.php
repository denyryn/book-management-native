<?php
header("Content-Type: application/json");

require '../../db_connection.php';
require '../controllers/CategoryController.php';

$controller = new CategoryController($pdo);

// helper for JSON response
function respond($data, $status = 200)
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;

        if ($slug) {
            $result = $controller->showBySlug($slug);
            respond($result ?: ['success' => false, 'error' => 'Category not found'], $result ? 200 : 404);
        }

        if ($id) {
            $result = $controller->show($id);
            respond($result ?: ['success' => false, 'error' => 'Category not found'], $result ? 200 : 404);
        }

        respond($controller->index());
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        if (empty($input['name'])) {
            respond(['success' => false, 'error' => 'Name is required'], 400);
        }

        $result = $controller->store($input);
        respond($result, $result['success'] ? 201 : 400);
        break;

    case 'PUT':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$id || empty($input['name'])) {
            respond(['success' => false, 'error' => 'ID and name are required'], 400);
        }

        $result = $controller->update($id, $input);
        respond($result, $result['success'] ? 200 : 400);
        break;

    case 'DELETE':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        if (!$id) {
            respond(['success' => false, 'error' => 'ID is required'], 400);
        }

        $result = $controller->delete($id);
        respond($result, $result['success'] ? 200 : 400);
        break;

    default:
        respond(['error' => 'Method not allowed'], 405);
}
