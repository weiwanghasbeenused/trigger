<?

?>
<div id = "main_ctner_home">
	<div id = "upcoming_ctner">
		<? for($i = 0 ; $i < $home_upcoming_limit ; $i++){
			if(isset($upcoming_events[$i])){
			?>

			<a class = "event event_upcoming" href = "/events/upcoming/<? echo $upcoming_events[$i]['url']; ?>">
				<div class = "event_upcoming_img"><img src = "<? 
					if(!empty($upcoming_events[$i]['thumbnail'])){
						echo $upcoming_events[$i]['thumbnail']; 
					}
				?>"></div>
				<h3 class = "event_upcoming_date"><? 
					if(!empty($upcoming_events[$i]['event_date'])){
						echo date("m.d", strtotime($upcoming_events[$i]['event_date'])); 
					}
				?></h3>
				<div class = "event_upcoming_info">
					<h4><? echo $upcoming_events[$i]['cato']; ?>:</h4>
					<h4 class = "event_upcoming_title"><? echo $upcoming_events[$i]['name1']; ?></h4>
					<h6></h6>
				</div>
			</a>
		<? }} ?>
	</div>
</div>
<script type = "text/javascript" src = "/controller/nav_controller.js"></script>
<script src = "controller/imgXTracking_controller.js"></script>