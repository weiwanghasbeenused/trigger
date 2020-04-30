<div id = "main_ctner_list_<? echo $thisView; ?>" class = 'main_ctner main_ctner_list'>
	<? if($home_upcoming_limit !== 0){ ?>
	<div id = "upcoming_ctner">
		<? echo ( $thisView == 'home' ) ? '<h4 id = "upcoming_ctner_title" class = "ctner_title">Upcoming&darr;</h4>' : ''; 
			foreach($upcoming_events as $ue){
			?>
			<a class = "event event_upcoming explodeCtner" href = "/events/upcoming/<? echo $ue['url']; ?>">
				<svg class = 'explode'></svg>
				<div class = "event_upcoming_img"><img src = "<? 
					if(!empty($ue['thumbmail']))
						echo $ue['thumbmail']; 
				?>"></div>
				<h3 class = "event_upcoming_date"><? 
					if(!empty($ue['event_date'])){
						echo date("m.d", strtotime($ue['event_date'])); 
					}
				?></h3>
				<div class = "event_upcoming_info">
					<h4><? echo $ue['cato']; ?>:</h4>
					<h4 class = "event_upcoming_title"><? echo $ue['name1']; ?></h4>
				</div>
			</a>
		<?
		}
		echo ( $thisView == 'home' ) ? '<div id = "more_upcoming" class = "more" ><a  href = "/events/upcoming">More upcoming events&rarr;</a></div>' : '' ;
		?>
	</div>
	<?
	}
	if($home_archive_limit !== 0){
	?>
	<div id = "arch_ctner">
		<? echo ( $thisView == 'home' ) ? '<h4 id = "arch_ctner_title" class = "ctner_title">Archive&darr;</h4>' : '' ; 
			foreach($archive_events as $ae){
			?>
			<a class = "event event_arch explodeCtner" href = "/events/archive/<? echo $ae['url']; ?>">
				<svg class = 'explode'></svg>
				<div class = "event_arch_img"><img src = "<? 
					if(!empty($ae['thumbnail'])){
						echo $ae['thumbnail']; 
					}
				?>"></div>
				<h3 class = "event_arch_date"><? 
					if(!empty($ae['event_date'])){
						echo date("m.d", strtotime($ae['event_date'])); 
					}
				?></h3>
				<h4 class = "event_arch_cato"><? echo $ae['cato']; ?></h4>
				<h4 class = "event_arch_title"><? echo $ae['name1']; ?></h4>
			</a>
		<?
		}
		echo ( $thisView == 'home' ) ? '<div id = "more_archive" class = "more"><a href = "/events/archive">More archive events&rarr;</a></div>':'' ;
		?>
	</div>
	<?
	}
	?>
</div>
