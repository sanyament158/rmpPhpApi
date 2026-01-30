<?php
header('Content-Type: application/json, charset=utf8');

try {
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);

	$table_name = $input_data['table_name'] ?? '';
	$field_name = $input_data['field_name'] ?? '';
	$field_new_value = $input_data['field_new_value'] ?? '';
	$id = $input_data['id'] ?? '';

	if (empty($table_name) || empty($field_name) || empty($id)){
		echo json_encode(['success' => false, 'error' => 'some parpam was null']);
		exit;
	}

	$stmt = $pdo->prepare('update '. $table_name .' set '. $field_name .' = ? where id = ?');
        $result = $stmt->execute([$field_new_value, $id]);
	if ($result){
		echo json_encode(['success' => true]);
	}
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}

?>
