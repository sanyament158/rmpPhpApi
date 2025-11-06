<?php
	header('Content-Type: application/json; charset=utf8');
	
	//connect db
	try{
		include '../connection/connection.php';
	} catch (PDOException $e){
		echo json_encode(['success' => false, 'error' => $e->getMessage()]);
		exit;
	}

	//fetch data
	$input = file_get_contents('php://input');
	$input_data = json_decode($input, true);

	//parameters
	try{
		$title = $input_data['title'];
		$description = $input_data['description'];
	} catch(Exception $e){
		echo json_encode(['success' => false, 'error' => $e->getMessage()]);
		exit;
	}
	
	// sql logic 
	
	try{
		$stmt = $pdo->prepare('insert into Tasks(IdOwner, IdStatus, IdCategory, IdImportance, Title, Description, IsComplete) values (1, 1, 1, 1, ?, ?, true)');
		$result = $stmt->execute([$title, $description]);
	} catch (Exception $e) {
		echo json_encode(['success' => false, 'error' => $e->getMessage()]);
		exit;
	}
	

	if ($result){	
	echo json_encode([
		'success' => true,
		'title' => $title,
		'description' => $description
	]);
	} else { 
		echo json_encode(['success' => false, 'result' => 'false']); 
	}
?>
