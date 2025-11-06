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
		    `user`.Username as Owner,
		    `status`.Name as Status,
		    category.Name as Category,
		    importance.Name as Importance,
		    task.Title,
		    task.Description,
		    task.IsComplete 
		from Tasks task 
		    inner join User `user` on task.IdOwner = user.Id
		    inner join TaskStatus `status` on task.IdStatus = status.Id
		    inner join TaskCategory category on task.IdCategory = category.Id
		    inner join TaskImportance importance on task.IdImportance = importance.Id
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
