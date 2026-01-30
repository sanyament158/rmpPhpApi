<?php
header('Content-Type: application/json, charset=utf8');

try {
    	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);

	$idScope = $input_data['idScope'] ?? '';
	$idResponsibleUser = $input_data['idResponsibleUser'] ?? '';

	if (empty($idScope) || empty($idResponsibleUser)) {
		echo json_encode(['success' => false, 'error' => 'some parpam was null']);
		exit;
	}

	$stmt = $pdo->prepare('insert into responsibility (idScope, idResponsibleUser) values (?, ?)');
       	$result = $stmt->execute([$idScope, $idResponsibleUser]);
	
	if ($result) {
		echo json_encode(['success' => true]);
	}
} 
catch (PDOException $ex) {
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>
