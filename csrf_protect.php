<?php
// csrf_protect.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $headers = getallheaders();
    $csrf_token = $headers['X-CSRF-Token'] ?? '';

    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'CSRF token invalid']);
        exit;
    }
}
