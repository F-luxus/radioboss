<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

require 'vendor/autoload.php';
$server = $_POST['server'];
$port = $_POST['port'];
$pass = $_POST['pass'];
$action = $_POST['action'];
$client = new \RadioBoss\RadioBossAPIClient("$server", "$port", "$pass");
$api = new \RadioBoss\RadioBossAPI($client);

try {
    $api->scheduleList();
} catch (Exception $e) {
    echo 'FAILED';
    exit();
}


if($action=="mic"){
	echo $api->toggleMicrophone();
}
if($action=="getmic"){
    header('Content-Type: application/json');
    echo json_encode($api->getMicrophone());
    exit;
}
if($action=="next"){
	$a = $api->PlayNext();
	echo $a;
}
if($action=="events"){
	$event = $api->scheduleList();
	$number = substr_count($event, 'TaskName=');
	echo"<hr><br>";
	for($i=0; $i<$number; $i++){
		$events = explode("TaskName=",$event);
		$events = explode(" ",$events[$i+1]);
		
		$ids = explode("Id=",$event);
		$ids = explode(" ",$ids[$i+1]);
	
		$events = str_replace('"','',$events[0]);
		$ids = str_replace('"','',$ids[0]);
		?>

		<input onclick="runevent('<?php echo $ids; ?>','<?php echo $events; ?>');" type="button" id="data" class="butt" value="<?php echo $events; ?>" /><br><br>
		<?php
	}
	echo"<hr>";
}
if($action=="songs"){

$er = $api->getPlaybackInfo()->getplayback();
$duration = $api->getPlaybackInfo()->getplayback()->getlength();
$position = $api->getPlaybackInfo()->getplayback()->getposition();
$left = round(($duration - $position)/1000);
function secondsToTime($lef) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$lef");
    return $dtF->diff($dtT)->format('%i minutes %s seconds');
}
$cur = $api->getPlaybackInfo()->getcurrentTrack()->getcasttitle();
$next = $api->getPlaybackInfo()->getNextTrack()->getcasttitle();
echo "Dabar groja: <b>$cur</b><br>";
echo "Iki kitos dainos liko: <b>".secondsToTime($left)."</b><br>";
echo "Kita daina: <b>$next</b><br>";


}

if($action=="run"){
	$id = $_POST[id];
	$name = $_POST[name];
	echo "$name ". $api->RunEvent($id);
}
///--------------------------------///
if($action=="realtime"){
    $duration = $api->getPlaybackInfo()->getplayback()->getlength();
    $position = $api->getPlaybackInfo()->getplayback()->getposition();
    $data =[
      'current_song' => $api->getPlaybackInfo()->getcurrentTrack()->getcasttitle(),
      'next_song' => $api->getPlaybackInfo()->getNextTrack()->getcasttitle(),
      'song_position' => $api->getPlaybackInfo()->getplayback()->getposition(),
      'song_left' => round(($duration - $position)/1000),
    ];
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}