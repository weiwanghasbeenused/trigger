<?
require_once('controller/home_controller.php');

?>
<div id = "main_ctner_home">
	<div id = "upcoming_ctner">
		<? foreach($upcoming_events as $up){?>
			<a class = "event event_upcoming" href = "/events/upcoming/<? echo $up['url']; ?>">
				<div class = "event_upcoming_img"><img src = "<? 
					if(!empty($upcoming_tn_url[$up['id']])){
						echo m_url($upcoming_tn_url[$up['id']]); 
					}
				?>"></div>
				<h3 class = "event_upcoming_date"><? 
					if(!empty($up['event_date'])){
						echo date("m.d", strtotime($up['event_date'])); 
					}
				?></h3>
				<div class = "event_upcoming_info">
					<h6><? echo $up['cato']; ?></h6>
					<h4 class = "event_upcoming_title"><? echo $up['name1']; ?></h4>
					<h6></h6>
				</div>
			</a>
		<? } ?>
		<div id = "more_upcoming">
			<h6>More upcoming events</h6>
		</div>
	</div>

	<div id = "arch_ctner">
		<? foreach($archive_events as $ar){?>
			<a class = "event event_arch" href = "/events/archive/<? echo $ar['url']; ?>">
				<div class = "event_arch_img"><img src = "<? 
					if(!empty($archive_tn_url[$ar['id']])){
						echo m_url($archive_tn_url[$ar['id']]); 
					}
				?>"></div>
				<h3 class = "event_arch_date"><? 
					if(!empty($ar['event_date'])){
						echo date("m.d", strtotime($ar['event_date'])); 
					}
				?></h3>
				<h6 class = "event_arch_cato"><? echo $ar['cato']; ?></h6>
				<h4 class = "event_arch_title"><? echo $ar['name1']; ?></h4>
			</a>
		<? } ?>
	</div>
</div>
<script type = "text/javascript" src = "/controller/nav_controller.js"></script>
<script src = "controller/imgXTracking_controller.js"></script>