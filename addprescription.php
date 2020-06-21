<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    include_once 'db.php';

//    if(isset($_GET['user_id'])){
        $json = file_get_contents('php://input');
    	$data = json_decode($json,true);

    	$stmt = $pdo->query("SET NAMES UTF8");
    	
	$stmt = $pdo->prepare("INSERT INTO t_prescription (user_id, doctor_name, medical, medtype, user_to, dstart, dfinish, times) VALUES (?,?,?,?,?,?,?,?)");
	$stmt->execute([$data['user_id'], $data['doctor_name'], $data['medical'], $data['medtype'], $data['user_to'], $data['dstart'], $data['dfinish'], json_encode($data['times'])]); 
    	$res = [
	    'id' => $data['user_id'],
	    'Operation' => 'addPrescription',
	    'Status' => 'Ok'
	];
    	echo json_encode($res);
//    }else{
//        header(http_response_code(401));
//    }

?>



