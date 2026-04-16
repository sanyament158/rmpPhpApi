<?php 
	try{ 
		include '../connection/connection.php';
		header('Content-Type: application/json; charset=utf-8');

		$stmt = $pdo->prepare(<<<SQL
select t.id as Id,
u.id as IdOwner,
u.username as OwnerUsername,
u.lname as OwnerLname,
u.idRole as OwnerIdRole, 
r.name as OwnerRoleName,
t.idStatus as IdStatus,
ts.name as StatusName,
t.title as Title,
t.description as Description,
t.idScope as IdScope,
s.name as ScopeName,
t.since as Since,
t.deadline as Deadline,
t.idUserTaked
from task t
inner join user u on u.id = t.idOwner
inner join role r on r.id = u.idRole
inner join taskStatus ts on ts.id = t.idStatus
inner join scope s on t.idScope = s.id
;
SQL);
		$stmt->execute();

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode([
			'success' => true,
			'data' => $results,
			'count' => count($results)	
		]);	
	}
	catch (PDOException $e){
		http_response_code(500);
		echo json_encode([
			'success' => false,
			'error' => $e->getMessage()	
		]);
	}

?>
