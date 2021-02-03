<?
$upcoming_events = getUpcomingEvents(4);
$archive_events = getArchiveEvents(10);
?>
<section id = 'home-container' class = 'main-container'>
	<div id = 'upcoming-listing-container' class = 'listing-container'>
		<p id = 'listing-section-title-upcoming' class='listing-section-title caption-bold'>Upcoming</p>
		<? 
		if( !empty($upcoming_events) ){
			$current_year = date('Y', strtotime($upcoming_events[0]['begin']));
			$event_counter = 0;
			?><div class = 'year-container'><p class = 'year date-small'><?= $current_year; ?>.</p><?
			foreach($upcoming_events as $event)
			{
				$event_counter++;
				$event_begin = strtotime($event['begin']);
				$event_year = date('Y', $event_begin);
				$event_date = date('m.d', $event_begin);
				$event_title_arr = prepareTitle($event['name1']);
				$event_tag_arr = $event_title_arr['tag'];
				$event_title = $event_title_arr['title'];
				var_dump($event_tag_arr);
				// $event_subtitle = $event_title_arr['event_subtitle'];
				$event_media = $oo->media($event['id']);
				$event_thumbnail_url = getEventThumbnail($event_media);
				
				

				if($event_year != $current_year)
				{
					$current_year = $event_year;
					?></div><div class = 'year-container'><p class = 'year date-small'><?= $current_year; ?>.</p><?
				}
			?>
				<a class = 'event upcoming-event explodeTrigger <?= ($event_counter%2 == 0) ? 'even' : 'odd'; ?> <?= $event_thumbnail_url ? "" : "noThumbnail" ?>' href="/upcoming/<?= $event['url']; ?>" triggerType = "hover">
					<div class='explodeCtner'><svg class = 'explode'></svg></div>
					<div class = "event-thumbnailCtner"><?= $event_thumbnail_url ? '<img class = "event-thumbnail" src = "'. $event_thumbnail_url.'">' : ''; ?></div>
					<p class = 'event-date date-large text-outline'><?= $event_date; ?></p><div class = 'event-info'>
						<div class='event-tag-container'><? foreach($event_tag_arr as $tag){ ?><p class = 'event-tag caption-roman'><?= $tag; ?></p><? } ?></div><h2 class = 'event-title body-medium'><?= $event_title; ?></h2>
					</div>
				</a>
			<?
			}
			?></div><div class = 'centered-link'><a class = 'tag caption-roman' href = '/upcoming'>More Upcoming Events</a></div>
			<?
		
		}
		else{
		?>
			<p id = 'alert-noUpcoming' class='event-title-large'>Currently there are no upcoming events.</p>
		<?
		} 
		?>
	</div>
	<div id = 'archive-listing-container' class = 'listing-container'>
		<p id = 'listing-section-title-archive' class='listing-section-title caption-bold'>Archive</p>
		<? 
		if( !empty($archive_events) ){
			$current_year = date('Y', strtotime($archive_events[0]['begin']));
			$event_counter = 0;
			?><div class = 'year-container'><p class = 'year date-small'><?= $current_year; ?>.</p><?
			foreach($archive_events as $event)
			{
				$event_counter++;
				$event_begin = strtotime($event['begin']);
				$event_year = date('Y', $event_begin);
				$event_date = date('m.d', $event_begin);
				$event_title_arr = prepareTitle($event['name1']);
				$event_tag_arr = $event_title_arr['tag'];
				$event_title = $event_title_arr['title'];
				$event_media = $oo->media($event['id']);
				$event_thumbnail_url = getEventThumbnail($event_media);
				
				if($event_year != $current_year)
				{
					$current_year = $event_year;
					?></div><div class = 'year-container'><p class = 'year date-small'><?= $current_year; ?>.</p><?
				}
			?>
				<a class = 'event archive-event explodeTrigger <?= $event_thumbnail_url ? "" : "noThumbnail" ?>' href="/archive/<?= $event['url']; ?>" triggerType = "hover">
					<div class='explodeCtner'><svg class = 'explode'></svg></div>
					<div class = "event-thumbnailCtner"><?= $event_thumbnail_url ? '<img class = "event-thumbnail" src = "'. $event_thumbnail_url.'">' : ''; ?></div>
					<p class = 'event-date date-small text-outline'><?= $event_date; ?></p><div class = 'event-info'>
						<div class='event-tag-container'><? foreach($event_tag_arr as $tag){ ?><p class = 'event-tag caption-roman'><?= $tag; ?></p><? } ?></div><h2 class = 'event-title body-medium'><?= $event_title; ?></h2>
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
	</div>
</section>

<script type = "text/javascript" src = "/static/js/imgXTracking_controller.js"></script>
