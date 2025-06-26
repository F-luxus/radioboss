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
if($action=="events1"){
    $event = $api->scheduleList();
    $xml = simplexml_load_string($event, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    $data = [];
    $html = '';
    foreach($array['item'] as $key=>$event){
        $event1 = $event['@attributes'];
        if($event1['EnabledEvent'] == 'True'){
            $html.='<tr style="text-align: center;">';
            $event_id  = '"'.$event1['Id'].'"';
            $html.='<td style="padding: 20px;">'.$event1['TaskName'].'</td>';
            $html.='<td>'.$event1['TimeToStart'].'</td>';
            $html.="<td><span class='event_button' onclick='playEvent($event_id)'>Paleisti</span></td>";
            $html.='</tr>';
        }
    }
    print_r($html);
    exit();
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