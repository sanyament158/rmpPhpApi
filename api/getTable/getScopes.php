<?php

	header('Content-Type: application/json; charset=utf-8');
	try{
		include '../connection/connection.php';

		//sql logic
		$stmt = $pdo->prepare(<<<SQL
			select name as Name, id as Id from scope;
		SQL);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode(
			[
				'success' => true,
				'data' => $results,
				'count' => count($results)
			]	
		);
	}
	catch (PDOException $e){
		http_response_code(500);
		echo json_encode([
			'success' => false,
			'error' => $e->getMessage()
		]);
	}
?>
