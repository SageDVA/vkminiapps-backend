<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    include_once 'db.php';

//    if(isset($_GET['user_id'])){
        $json = file_get_contents('php://input');
    	$data = json_decode($json,true);

    	$stmt = $pdo->query("SET NAMES UTF8");
    	
	$stmt = $pdo->prepare("INSERT INTO t_tracking (user_id, medical, medtype, doctor, dstart, dfinish, times) VALUES (?,?,?,?,?,?,?)");
	$stmt->execute([$data['user_id'], $data['medical'], $data['medtype'], $data['doctor'], $data['dstart'], $data['dfinish'], json_encode($data['times'])]); 
    	$res = [
	    'id' => $data['user_id'],
	    'Operation' => 'addTracking',
	    'Status' => 'Ok'
	];
    	echo json_encode($res);
//    }else{
//        header(http_response_code(401));
//    }

?>



