<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    include_once 'db.php';

//    if(isset($_GET['user_id'])){
        $json = file_get_contents('php://input');
    	$data = json_decode($json,true);

    	$stmt = $pdo->query("SET NAMES UTF8");
    	
	$stmt = $pdo->prepare("INSERT INTO t_finance (user_id, medical, pharm, dpurch, cost) VALUES (?,?,?,?,?)");
	$stmt->execute([$data['user_id'], $data['medical'], $data['pharm'], $data['dpurch'], $data['cost']]); 
    	$res = [
	    'id' => $data['user_id'],
	    'Operation' => 'addFinance',
	    'Status' => 'Ok'
	];
    	echo json_encode($res);
//    }else{
//        header(http_response_code(401));
//    }

?>



