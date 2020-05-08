<?
$ee = new Events();

$upcoming_events_media = $oo->media($upcoming_events[0]['id']);
$upcoming_tn_url = array();
$archive_tn_url = array();

$hasUpcoming = true;

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
	if(count($upcoming_events)!=0){
		var_dump($upcoming_events);
		foreach($upcoming_events as &$ue){
			$ue['event_date'] = isset($ue['event_date']) ? date("m.d", strtotime($ue['event_date'])) : '';
			$ue['url'] = isset($ue['url']) ? '/events/upcoming/'+$ue['url'] : '#null';
		}
		unset($ue);
	}else{
		$hasUpcoming = false;
		$upcoming_events = array(
			array(
				"event_date" => "<span id = 'no_upcoming_msg'>Currently there are <br>no upcoming events.</span>",
				"url" => '#null'
			)
		);

	}

}
if($home_archive_limit !== 0){
	$archive_events = $ee->get_archive($home_archive_limit);
	$archive_events_ordered = array();
	$year = 0;
	foreach($archive_events as $ae){
		$this_year = date("Y", strtotime($ae['event_date']));
		if( isset($ae['main_two'])){
			if($this_year != $year){
				$year = $this_year;
				$archive_events_ordered[] = array('new_year'=>$year);
			}
			$ae['event_date'] = date("m.d", strtotime($ae['event_date']));
			$archive_events_ordered[] = $ae;
		}
	}
}

require_once("views/home.php");
?>

<script type = "text/javascript" src = "/controller/imgXTracking_controller.js"></script>
