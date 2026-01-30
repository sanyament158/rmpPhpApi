<?php
header('Content-Type: application/json; charset=utf-8');

try{
	include '../connection/connection.php';	
	$stmtUsers = $pdo->prepare(<<<SQL
select u.id as Id,
u.username as Username,
u.lname as Lname,
u.idRole as RoleId,
r.name as RoleName
from user u
inner join role r on r.id = u.idRole;
SQL);
	$stmtUsers->execute();
	$resultsUsers = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

	$stmtResponsibility = $pdo->prepare('select * from responsibility');
	$stmtResponsibility->execute();
	$resultsResponsibility = $stmtResponsibility->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode(['success' => true, 'user' => $resultsUsers, 'responsibility' => $resultsResponsibility]);
}
catch (PDOException $ex){
	http_response_code(500);
	echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
?>
