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
		foreach($upcoming_events as &$ue){
			$ue['event_date'] = isset($ue['event_date']) ? date("m.d", strtotime($ue['event_date'])) : '';
			$ue['url'] = '/events/upcoming/'.$ue['url'];
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

?>
<div id = "main_ctner_list_<? echo $thisView; ?>" class = 'main_ctner main_ctner_list'>
	<? if($home_upcoming_limit !== 0){ ?>
	<div id = "upcoming_ctner">
		<? echo ( $thisView == 'home' ) ? '<h4 id = "upcoming_ctner_title" class = "ctner_title">Upcoming&darr;</h4>' : ''; 
			foreach($upcoming_events as $ue){
			?>
			<a class = "event event_upcoming explodeCtner" href = "<? echo isset($ue['url']) ? $ue['url'] : '' ?>">
				<svg class = 'explode'></svg>
				<div class = "event_upcoming_img"><img src = "<? 
					if(!empty($ue['thumbmail']))
						echo $ue['thumbmail']; 
				?>"></div>
				<h3 class = "event_upcoming_date"><? 
					if(!empty($ue['event_date'])){
						echo $ue['event_date']; 
					}
				?></h3>
				<div class = "event_upcoming_info">
					<h4><? echo ( !empty($ue['cato']) ) ? $ue['cato'].':' : '' ; ?></h4>
					<h4 class = "event_upcoming_title"><? echo $ue['name1']; ?></h4>
				</div>
			</a>
		<?
		}
		echo ( $thisView == 'home' && $hasUpcoming ) ? '<div id = "more_upcoming" class = "more" ><a  href = "/events/upcoming">More upcoming events&rarr;</a></div>' : '' ;
		?>
	</div>
	<?
	}
	if($home_archive_limit !== 0){
	?>
	<div id = "arch_ctner">
		<? echo ( $thisView == 'home' ) ? '<h4 id = "arch_ctner_title" class = "ctner_title">Archive&darr;</h4>' : '' ; 
			foreach($archive_events_ordered as $aeo){
				if(isset($aeo['new_year'])){
			?>
			<h6 class = 'year'><? echo $aeo['new_year']; ?></h6>
			<? }else{ ?>
			<a class = "event event_arch explodeCtner" href = "/events/archive/<? echo $aeo['url']; ?>">
				<svg class = 'explode'></svg>
				<div class = "event_arch_img"><img src = "<? 
					if(!empty($aeo['thumbnail'])){
						echo $aeo['thumbnail']; 
					}
				?>"></div>
				<h3 class = "event_arch_date"><? 
					if(!empty($aeo['event_date'])){
						echo $aeo['event_date']; 
					}
				?></h3>
				<h4 class = "event_arch_cato"><? echo $aeo['cato']; ?></h4>
				<h4 class = "event_arch_title"><? echo $aeo['name1']; ?></h4>
			</a>
		<? }
		}
		echo ( $thisView == 'home' ) ? '<div id = "more_archive" class = "more"><a href = "/events/archive">More archive events&rarr;</a></div>':'' ;
		?>
	</div>
	<?
	}
	?>
</div>
<script type = "text/javascript" src = "/controller/imgXTracking_controller.js"></script>
