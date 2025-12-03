<?php
	try{
		// connect db & setup header
		include '../connection/connection.php';
		header('Content-Type: application/json; charset=utf-8');
	} catch (Exception $e){
		echo json_encode(['success' => false, 'error' => $e->getMessage()]);
	}

	try{
		// sql logic
		$stmt = $pdo->prepare(<<<SQL
		select 
		    `user`.username as Owner,
		    `status`.name as Status,
		    scope.name as Scope,
		    importance.name as Importance,
		    task.title,
		    task.description
		from task task 
		    inner join user `user` on task.idOwner = user.Id
		    inner join taskStatus `status` on task.idStatus = status.Id
		    inner join scope scope on task.idScope = scope.id
		    inner join taskImportance importance on task.idImportance = importance.Id
		SQL
		); 
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// convert tinyint to boolean (IsComplete)
		foreach($results as &$row) {
			if (isset($row['IsComplete'])){
				$row['IsComplete'] = (bool)$row['IsComplete'];
			}
		}

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
