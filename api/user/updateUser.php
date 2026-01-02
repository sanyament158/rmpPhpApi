<?php
header('Content-Type: applicaton/json; charset=utf-8');
try{
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);
	$id = $input_data['id'] ?? '';
	$login = $input_data['login'] ?? '';
	$lname = $input_data['lname'] ?? '';
	$idRole = $input_data['idRole'] ?? '';
	$password = $input_data['password'] ?? '';

	if (empty($id) || empty($login) || empty($lname) || empty($idRole) || empty($password)){
		echo json_encode(['success' => false, 'error' => 'some field was null']);
		exit;
	}
	$stmt = $pdo->prepare(<<<SQL
update user
set 
	username = ?,
	lname = ?,
	idRole = ?,
	password = ?
where id = ?
SQL);
	$result = $stmt->execute([$login, $lname, $idRole, $password, $id]);
	if ($result){
		echo json_encode(['success' => true, 'username' => $login]);
	}
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>
