<?php
header("Content-Type: application/json; charset=utf-8");
try{
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);
	$idUser = $input_data['idUser'] ?? '';
	$idScope = $input_data['idScope'] ?? '';

	if (empty($idUser) || empty($idScope)){
		echo json_encode(['success' => false, 'message' => 'some field was empty']);
		exit;
	}

	$stmt = $pdo->prepare('delete from responsibility where idScope = ? and idResponsibleUser = ?');
	$result = $stmt->execute([$idScope, $idUser]);
	if ($result){
		echo json_encode(['success' => true]);
	}
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>
