<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    include_once 'db.php';


    if($_GET['user_to']){
        $user_to = $_GET['user_to'];

    	$query = $pdo->query("SET NAMES UTF8");

	$query = $pdo->prepare("select * from t_prescription where user_to = ?");
	$query->execute([$user_to]); 
        $res = array();
	foreach ($query as $row) {
	    $element = ['id' => $row['id'], 'user_id' => $row['user_id'], 'doctor_name' => $row['doctor_name'], 'medical' => $row['medical'], 'medtype' => $row['medtype'],'user_to' => $row['user_to'], 'dstart' => $row['dstart'], 'dfinish' => $row['dfinish'], 'times' => $row['times']];
	    $res[] = $element;
	}
    	echo json_encode($res);
    }else{
//        header(http_response_code(401));
        $res = array();
        echo json_encode($res);
    }

?>
