<?php
header ('Content-Type: application/json; charset=utf-8');
try{
	include '../connection/connection.php';

	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);

	$idOwner = $input_data['idOwner'] ?? '';
	$idStatus = $input_data['idStatus'] ?? '';
	$title = $input_data['title'] ?? '';
	$idScope = $input_data['idScope'] ?? '';
	$since = $input_data['since'] ?? '';
	$deadline = $input_data['deadline'] ?? '';

	if (empty($idOwner) || empty($idStatus) || empty($title) ||empty($idScope) || empty($since) || empty($deadline)){
		echo json_encode(['success' => false, 'error' => 'some field was null']);
		exit;
	}
	$stmt = $pdo->prepare(<<<SQL
insert into task (idOwner, idStatus, title, idScope, since, deadline)
values (?, ?, ?, ?, ?, ?);
SQL);
	$result = $stmt->execute([$idOwner, $idStatus, $title, $idScope, $since, $deadline]);
	if ($result){
		echo json_encode(['success' => true]);
	}
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}

?>
