<?php
header('Content-Type: application/json; charset=utf-8');

try{
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);

	$id = $input_data['id'] ?? '';

	if (empty($id)){
		echo json_encode(['success' => false, 'error' => 'id was null']);
		exit;
	}

	$stmt = $pdo->prepare('select id, password from user where id = ?');
	$stmt->execute([$id]);
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	echo json_encode(['success' => true, 'data' => $results]);
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>
