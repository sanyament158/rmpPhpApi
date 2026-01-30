<?php
header ('Content-Type: application/json; charset=utf-8');
try{
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);

	$idTask = $input_data['idTask'] ?? '';
	$idFinishedUser = $input_data['idFinishedUser'] ?? '';

	if (empty($idTask) || empty($idFinishedUser)){
		echo json_encode(['success' => false, 'error' => 'some field was empty']);
		exit;
	}

	$stmt = $pdo->prepare(<<<SQL
insert into finishedTasks (idTask, idFinishedUser) values (?, ?);
SQL);
	$result = $stmt->execute([$idTask, $idFinishedUser]);
	if ($result) {
		echo json_encode(['success' => true]);
	}
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>

