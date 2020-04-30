<?
$ee = new Events();

$upcoming_events_media = $oo->media($upcoming_events[0]['id']);
$upcoming_tn_url = array();
$archive_tn_url = array();



if(count($uri) < 3){
	$home_upcoming_limit = 4;
	$home_archive_limit = 10;
	$thisView = 'home';
}elseif($uri[2] == "upcoming"){
	$home_upcoming_limit = '';
	$home_archive_limit = 0;
	$thisView = 'upcoming';
}elseif($uri[2] == "archive"){
	$home_upcoming_limit = 0;
	$home_archive_limit = '';
	$thisView = 'archive';
}
if($home_upcoming_limit !== 0){
	$upcoming_events = $ee->get_upcoming($home_upcoming_limit);
	foreach($upcoming_events as $ue)
		$ue['event_date'] = date("m.d", strtotime($ue['event_date']));
}
if($home_archive_limit !== 0){
	$archive_events = $ee->get_archive($home_archive_limit);
	foreach($archive_events as $ae)
		$ae['event_date'] = date("m.d", strtotime($ae['event_date']));
}

require_once("views/home.php");
?>

<script type = "text/javascript" src = "/controller/imgXTracking_controller.js"></script>
