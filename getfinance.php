<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    include_once 'db.php';


    if($_GET['user_id']){
        $user_id = $_GET['user_id'];

    	$query = $pdo->query("SET NAMES UTF8");

	$query = $pdo->prepare("select * from t_finance where user_id = ?");
	$query->execute([$user_id]); 
        $res = array();
	foreach ($query as $row) {
	    $element = ['user_id' => $row['user_id'], 'medical' => $row['medical'], 'pharm' => $row['pharm'], 'dpurch' => $row['dpurch'], 'cost' => $row['cost']];
	    $res[] = $element;
	}
    	echo json_encode($res);
    }else{
//        header(http_response_code(401));
        $res = array();
        echo json_encode($res);
    }

?>
