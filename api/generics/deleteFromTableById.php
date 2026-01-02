<?php
header ('Content-Type: application/json; charset=utf-8');

try{
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);
	$id = $input_data['id'] ?? '';
	$table_name = $input_data['table_name'] ?? '';

	if (empty($id) || empty($table_name)){
		echo json_encode([
			'success' => false,
			'error' => 'id was null'
		]);	
		exit;
	}
	$stmt = $pdo->prepare('delete from '. $table_name . ' where id = ?');
	$result = $stmt->execute([$id]);
	if ($result){

		echo json_encode([
			'success' => $result,
			'id' => $id,
			'table_name' => $table_name
		]);	
	}	
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode([
		'success' => false,
		'error' => $ex->getMessage()
	]);
}
?>
