<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    include_once 'db.php';


    if($_GET['user_id']){
        $user_id = $_GET['user_id'];

    	$query = $pdo->query("SET NAMES UTF8");

	$sql = "
select
    medical,
    medtype,
    times
from
    t_tracking
where
    user_id= ? 
    and (dstart  = '0000-00-00' or dstart  <= ?)
    and (dfinish = '0000-00-00' or dfinish >= ?)

";


        $query = $pdo->prepare($sql);
	$query->execute([$user_id, date("Y-m-d"), date("Y-m-d")]); 
        $res = array();
//        $cur_time = strtotime(date("G:i"));
        $cur_time = strtotime(date("H:i")) + (60*60*3);
                
	foreach ($query as $row) {
	    $times = json_decode($row['times'],true);
	    for($i=0; $i<count($times); $i++){
	        $med_time = $times[$i]['time'];
	        if ($med_time >= date("H:i", $cur_time)){
	            $element = ['medical' => $row['medical'], 'medtype' => $row['medtype'], 'time' => $times[$i]['time'], 'dose' => $times[$i]['dose']];
	            $res[] = $element;
                }
	    }
	}
        for($i=0; $i<count($res)-1; $i++)
            for($j=$i+1; $j<count($res); $j++)
                if($res[$i]['time'] > $res[$j]['time']){
                    $tmp = $res[$i];
                    $res[$i] = $res[$j];
                    $res[$j] = $tmp;
                }


    	echo json_encode($res);
    }else{
//        header(http_response_code(401));
        $res = array();
        echo json_encode($res);
    }

?>

