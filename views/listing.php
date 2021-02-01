<? 
	$thisEventType = $uri[1];
	if($thisEventType == 'upcoming')
		$events = getUpcomingEvents();
	else
		$events = getArchiveEvents();
?>
<section id = 'event-container' class = 'main-container'>
	<div id = '<?= $thisEventType; ?>-listing-container' class = 'listing-container'>
		<p id = '' class='listing-section-title caption-bold'>Listing</p>
		<? 
		if( $thisEventType == 'upcoming' ){
			if( !empty($events)){
				$current_year = date('Y', strtotime($events[0]['begin']));
				$event_counter = 0;
				?><div class = 'year-container'><p class = 'year date-small'><?= $current_year; ?>.</p><?
				foreach($events as $event)
				{
					$event_counter++;
					$event_begin = strtotime($event['begin']);
					$event_year = date('Y', $event_begin);
					$event_date = date('m.d', $event_begin);
					$event_title_arr = prepareTitle($event['name1']);
					$event_tag = $event_title_arr['tag'];
					$event_title = $event_title_arr['title'];
					$event_media = $oo->media($event['id']);
					$event_thumbnail_url = getEventThumbnail($event_media);				

					if($event_year != $current_year)
					{
						$current_year = $event_year;
						?></div><div class = 'year-container'><p class = 'year date-small'><?= $current_year; ?>.</p><?
					}
				?>
					<a class = 'event <?= $thisEventType; ?>-event explodeTrigger <?= ($event_counter%2 == 0) ? 'even' : 'odd'; ?> <?= empty($event_thumbnail_url) ? "noThumbnail" : "" ?>' href="/<?= $thisEventType; ?>/<?= $event['url']; ?>" triggerType="hover">
						<div class='explodeCtner'><svg class = 'explode'></svg></div>
						<div class = "event-thumbnailCtner"><img class = "event-thumbnail" src = "<?= $event_thumbnail_url; ?>"></div>
						<p class = 'event-date date-large text-outline'><?= $event_date; ?></p><div class = 'event-info'>
							<p class = 'event-tag caption-roman'><?= $event_tag; ?></p><h2 class = 'event-title body-medium'><?= $event_title; ?></h2>
						</div>
					</a>
				<?
				}
				?></div><?
			}
			else{
			?>
				<p id = 'alert-noUpcoming' class='event-title-large'>Currently there are no upcoming events.</p>
			<?
			} 
		}
		else
		{
			if( !empty($events) ){
			$current_year = date('Y', strtotime($events[0]['begin']));
			$event_counter = 0;
			?><div class = 'year-container'><p class = 'year date-small'><?= $current_year; ?>.</p><?
			foreach($events as $event)
			{
				$event_counter++;
				$event_begin = strtotime($event['begin']);
				$event_year = date('Y', $event_begin);
				$event_date = date('m.d', $event_begin);
				$event_title_arr = prepareTitle($event['name1']);
				$event_tag = $event_title_arr['tag'];
				$event_title = $event_title_arr['title'];
				$event_media = $oo->media($event['id']);
				$event_thumbnail_url = getEventThumbnail($event_media);
				
				if($event_year != $current_year)
				{
					$current_year = $event_year;
					?></div><div class = 'year-container'><p class = 'year date-small'><?= $current_year; ?>.</p><?
				}
			?>
				<a class = 'event <?= $thisEventType; ?>-event explodeTrigger <?= empty($event_thumbnail_url) ? "noThumbnail" : "" ?>' href="/<?= $thisEventType; ?>/<?= $event['url']; ?>" triggerType="hover">
					<div class='explodeCtner'><svg class = 'explode'></svg></div>
					<div class = "event-thumbnailCtner">
						<img class = "event-thumbnail" src = "<?= $event_thumbnail_url; ?>">
					</div>
					<p class = 'event-date date-small text-outline'><?= $event_date; ?></p><div class = 'event-info'>
						<p class = 'event-tag caption-roman'><?= $event_tag; ?></p><h2 class = 'event-title body-medium'><?= $event_title; ?></h2>
					</div>
				</a>
			<?
			}
			?></div><?
		
		}
		else{
		?>
			<p id = 'alert-noArchive' class='event-title-large'>Currently there are no archived events.</p>
		<?
		} 
		?>
	</div><?
		}
		?>
	</div>
</section>
<script type = "text/javascript" src = "/static/js/imgXTracking_controller.js"></script>

