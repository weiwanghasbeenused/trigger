<?
$ee = new Events();
$upcoming_events = $ee->get_upcoming();
$archive_events = $ee->get_archive();
$upcoming_events_media = $oo->media($upcoming_events[0]['id']);
$upcoming_tn_url = array();
$archive_tn_url = array();



if(count($uri) < 3){
	$home_upcoming_limit = 4;
	$home_archive_limit = 10;
	$thisView = 'home';
}elseif($uri[2] == "upcoming"){
	$home_upcoming_limit = count($upcoming_events);
	$home_archive_limit = 0;
	$thisView = 'upcoming';
}elseif($uri[2] == "archive"){
	$home_upcoming_limit = 0;
	$home_archive_limit = count($archive_events);
	$thisView = 'archive';
}

foreach($upcoming_events as $up){
	$upcoming_tn_url[] = $up['thumbnail'];
}
foreach($archive_events as $ar){
	$archive_tn_url[] = $up['thumbnail'];
}

require_once("views/home.php");
?>

<script type = "text/javascript" src = "/controller/imgXTracking_controller.js"></script>
