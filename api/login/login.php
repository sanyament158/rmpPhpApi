<?php
header('Content-Type: application/json; charset=utf-8');

include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "Введите логин и пароль"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt = $pdo->prepare("SELECT id, username, email, password, role, created_at FROM users WHERE username = ?");
$stmt->execute([$username, $password]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    unset($user['password']);
    echo json_encode([
        "success" => true,
        "user" => $user
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Неверный логин или пароль"
    ], JSON_UNESCAPED_UNICODE);
}
?>