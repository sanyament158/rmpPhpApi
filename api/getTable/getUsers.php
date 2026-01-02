<?php
header('Content-Type: application/json; charset=utf-8');

try{
	include '../connection/connection.php';
	
	$stmt = $pdo->prepare('select id as Id, username as Username, fname as Fname, lname as Lname, idRole as IdRole from user;');
	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode(['success' => true, 'data' => $results]);
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>
