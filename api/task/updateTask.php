<?php
header('Content-Type: application/json; charset=utf-8');
try{
	include '../connection/connection.php';
	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);

	$id = $input_data['id'] ?? '';
	$id_owner = $input_data['id_owner'] ?? '';
	$id_scope = $input_data['id_scope'] ?? '';
	$title = $input_data['title'] ?? '';
	$since = $input_data['since'] ?? '';
	$deadline = $input_data['deadline'] ?? '';
	

	if (empty($id) || empty($id_owner) || empty($id_scope) || empty($title) || empty($since) || empty($deadline)){
		echo json_encode(['success' => false, 'error' => 'id was null']);
		exit;
	}
	$stmt = $pdo->prepare(<<<SQL
update task 
set 
	idOwner = ?,
	title = ?,
	idScope = ?,
	since = ?,
	deadline = ?
where id = ?;
SQL);
	$result = $stmt->execute([$id_owner, $title, $id_scope, $since, $deadline, $id]);
	if ($result){
		echo json_encode(['success' => true]);
	}
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>
