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
    
    // from json to assoc array
    $inputData = json_decode($input, true);
    $username = $inputData['username'] ?? '';
    $password = $inputData['password'] ?? '';
    
    if (empty(trim($username)) || empty(trim($password))){
        throw new Exception('any field is empty');
    }

    // Проверяем на ошибки
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Ошибка декодирования JSON: ' . json_last_error_msg());
    }

    // sql logic 
    try{
        $stmt = $pdo->prepare('INSERT INTO User (Username, Password) VALUES (?, ?)');
        $stmt->execute([$username, $password]);
    }
    catch (Exception $e){
        die(json_encode(['success' => false, 'error' => $e->getMessage()]));
    }

    
    // put output data
    try{
        $outputData = [
            'success' => true,
            'username' => $username
        ];
        echo json_encode($outputData);
    }
    catch (PDOException $e){
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    


?>
