<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once 'models/UserModel.php';

$userModel = new UserModel();

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $userModel->auth($username, $password);

    if ($user) {
        session_start();
        $_SESSION['id'] = $user[0]['id'];

        echo json_encode([
            'status' => 'success',
            'user_id' => $user[0]['id'],
            'message' => 'Login successful',
            'redirect' => '/list_users.php'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid username or password'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Thiếu username hoặc password'
    ]);
}
