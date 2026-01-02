<?php
header('Content-Type: application/json; charset=utf-8');
try{
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);

	$username = $input_data['username'] ?? '';
	$lname = $input_data['lname'] ?? '';
	$idRole = $input_data['idRole'] ?? '';
	$password = $input_data['password'] ?? '';

	if (empty($username) || empty($lname) || empty($idRole) || empty($password)){
		echo json_encode(['success' => false, 'error' => 'some field was null']);
		exit;
	}
	$stmt = $pdo->prepare('insert into user (username, lname, idRole, password) values (?, ?, ?, ?);');
	$result = $stmt->execute([$username, $lname, $idRole, $password]);
	if ($result){
		echo json_encode(['success' => true, 'username' => $username]);
	}
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>
