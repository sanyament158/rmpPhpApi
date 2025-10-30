<?php
$host = '79.141.78.35';
$dbname = 'taskmanager';
$username = 'remoteUser';
$password = 'gogawho';

try {    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {    
    die(json_encode(['error' => 'Ошибка подключения: ' . $e->getMessage()]));
}
?>
