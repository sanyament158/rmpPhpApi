<?php
	// connect db
	include '../connection/connection.php';

	// set response's header
	header('Content-Type: application/json; charset=utf-8');

	try{
		$stmt = $pdo->prepare("SELECT * FROM user");
		$stmt->execute();

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode([
			'success' => true,
			'data' => $results,
			'count' => count($results)
		]);
	} catch (PDOException $e){
		http_response_code(500);
		echo json_encode([
			'success' => false,
			'error' => $e->getMessage()
		]);
	}
?>
