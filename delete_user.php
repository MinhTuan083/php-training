<?php
require_once 'csrf_protect.php';
require_once 'models/UserModel.php';

$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? null;

    if ($id) {
        $userModel->deleteUserById($id);
        echo json_encode(['status' => 'success', 'message' => 'User deleted']);
        exit;
    }
}

http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);

header('location: list_users.php');
?>