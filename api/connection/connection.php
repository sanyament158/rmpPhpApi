<?php
$host = '5.129.192.69';
$dbname = 'taskmanager';
$username = 'sanya-remote';
$password = 'gogachivchan';

try {    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {    
    die(json_encode(['error' => 'Ошибка подключения: ' . $e->getMessage()]));
}
?>
