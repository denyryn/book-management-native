<?php
header("Content-Type: application/json");

require '../../db_connection.php';
require '../controllers/BookController.php';

$controller = new BookController($pdo);

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

        if ($id) {
            $result = $controller->show($id);
        } else if (!empty($_GET)) {
            $queryParams = [
                'search' => $_GET['search'] ?? '',
                'category' => $_GET['category'] ?? '',
                'author' => $_GET['author'] ?? '',
                'publisher' => $_GET['publisher'] ?? '',
                'start_date' => $_GET['start_date'] ?? '',
                'end_date' => $_GET['end_date'] ?? ''
            ];
            $result = $controller->search($queryParams);
        } else {
            $result = $controller->index();
        }

        respond($result);
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        if (empty($input['title'])) {
            respond(['success' => false, 'error' => 'Title is required'], 400);
        }
        $result = $controller->store($input);
        respond($result, $result['success'] ? 201 : 400);
        break;

    case 'PUT':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$id || empty($input['title'])) {
            respond(['success' => false, 'error' => 'ID and title are required'], 400);
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
