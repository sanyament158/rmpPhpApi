<?php
header('Content-Type: application/json; charset=utf-8');

try{
include '../connection/connection.php';
} catch (PDOException $e){ 
	echo json_encode(["success" => false, "error" => $e->getMessage()]);
	exit;
}
// fetch data
$input = file_get_contents("php://input");

// from json to assoc array
$input_data = json_decode($input, true);
$username = $input_data['username'] ?? '';
$password = $input_data['password'] ?? '';

if (empty(trim($username)) || empty(trim($password))) {
    echo json_encode([
        "success" => false,
        "message" => "Введите логин и пароль"
    ]);
    exit;
}

$stmt = $pdo->prepare("SELECT Id, Username, Fname, Lname, IdRole, Password FROM User WHERE Username = ?");
$stmt->execute([$username]);
$user_obj = $stmt->fetch(PDO::FETCH_ASSOC);

// validation
try{
	if ($password == $user_obj['Password']) {
	    unset($user_obj['Password']);
	    echo json_encode([
		"success" => true,
		"user" => $user_obj]);
	} else {
	    echo json_encode([
		"success" => false,
		"message" => "Неверный логин или пароль"
	    ]);
	}
} catch (Exception $e){
	echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
