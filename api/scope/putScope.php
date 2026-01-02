<?php
header('Content-Type: application/json; charset=utf-8');

try{
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);
	$name = $input_data['name'] ?? '';

	if (empty($name)){
		echo json_encode([
			'success' => false,
			'error' => 'was null']);
		exit;
	}
	$stmt = $pdo->prepare('insert into scope (name) values (?)');
	$result = $stmt->execute([$name]);
	if ($result){
		echo json_encode([
			'success' => true,
			'name' => $name]);
	}
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['uccess' => false, 'error' => $ex->getMessage()]);
}
?>
