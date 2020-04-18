<div id = "main_ctner_list_<? echo $thisView; ?>" class = 'main_ctner main_ctner_list'>
	<? if($home_upcoming_limit){?>
	<div id = "upcoming_ctner">
		<? echo ( $thisView == 'home' ) ? '<h4 id = "upcoming_ctner_title" class = "ctner_title">Upcoming&darr;</h4>' : ''; 
		for($i = 0 ; $i < $home_upcoming_limit ; $i++){
			if(isset($upcoming_events[$i])){
			?>
			<a class = "event event_upcoming explodeCtner" href = "/events/upcoming/<? echo $upcoming_events[$i]['url']; ?>">
				<svg class = 'explode'></svg>
				<div class = "event_upcoming_img"><img src = "<? 
					if(!empty($upcoming_tn_url[$i]))
						echo $upcoming_tn_url[$i]; 
				?>"></div>
				<h3 class = "event_upcoming_date"><? 
					if(!empty($upcoming_events[$i]['event_date'])){
						echo date("m.d", strtotime($upcoming_events[$i]['event_date'])); 
					}
				?></h3>
				<div class = "event_upcoming_info">
					<h4><? echo $upcoming_events[$i]['cato']; ?>:</h4>
					<h4 class = "event_upcoming_title"><? echo $upcoming_events[$i]['name1']; ?></h4>
				</div>
			</a>
		<? }
		}
		echo ( $thisView == 'home' ) ? '<div id = "more_upcoming" class = "more" ><a  href = "/events/upcoming">More upcoming events&rarr;</a></div>' : '' ;
		?>
	</div>
	<?
	}
	if($home_archive_limit){
	?>
	<div id = "arch_ctner">
		<? echo ( $thisView == 'home' ) ? '<h4 id = "arch_ctner_title" class = "ctner_title">Archive&darr;</h4>' : '' ; ?>
		<? for($i = 0 ; $i < $home_archive_limit ; $i++){
			if(isset($archive_events[$i])){ ?>
			<a class = "event event_arch explodeCtner" href = "/events/archive/<? echo $archive_events[$i]['url']; ?>">
				<svg class = 'explode'></svg>
				<div class = "event_arch_img"><img src = "<? 
					if(!empty($archive_tn_url[$i])){
						echo $archive_tn_url[$i]; 
					}
				?>"></div>
				<h3 class = "event_arch_date"><? 
					if(!empty($archive_events[$i]['event_date'])){
						echo date("m.d", strtotime($archive_events[$i]['event_date'])); 
					}
				?></h3>
				<h6 class = "event_arch_cato"><? echo $archive_events[$i]['cato']; ?></h6>
				<h4 class = "event_arch_title"><? echo $archive_events[$i]['name1']; ?></h4>
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
