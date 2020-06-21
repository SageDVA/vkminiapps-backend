<?php
require_once 'vendor/autoload.php';
$vk = new VK\Client\VKApiClient();

$access_token = 'c787567fc787567fc787567ff9c7f5e7eecc787c787567f996a65755d4045c257ca6a56';


include_once 'db.php';
$query = $pdo->query("SET NAMES UTF8");

$sql = "
select
    user_id,
    medical,
    medtype,
    times
from
    t_tracking
where
    (dstart  = '0000-00-00' or dstart  <= ?)
    and (dfinish = '0000-00-00' or dfinish >= ?)

";
        $query = $pdo->prepare($sql);
	$query->execute([date("Y-m-d"), date("Y-m-d")]); 

        $cur_time = strtotime(date("H:i")) + (60*60*3);
        $fut_time = $cur_time + (60*5);

	foreach ($query as $row) {
	    $times = json_decode($row['times'],true);
	    for($i=0; $i<count($times); $i++){
                $med_time = $times[$i]['time'];
		if ($med_time >= date("H:i", $cur_time) && $med_time <= date("H:i", $fut_time)){
		    print 'Вам назначено в '.$times[$i]['time'].' '.$row['medtype'].' '.$row['medical'].' ('.$times[$i]['dose'].')!';
                    $response = $vk->Notifications()->sendMessage($access_token, [
                       'user_ids'   => [1, $row['user_id']],
                       'message'    => 'Вам назначено в '.$times[$i]['time'].' '.$row['medtype'].' '.$row['medical'].' ('.$times[$i]['dose'].')!'
                    ]);
                }
	    }
	}
?>