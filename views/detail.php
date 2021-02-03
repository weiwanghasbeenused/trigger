<?
	$thisEventType = $uri[1];
	$event_title_arr = prepareTitle($item['name1']);
	$event_tag_arr = $event_title_arr['tag'];
	$event_title = $event_title_arr['title'];
	$event_subtitle = $event_title_arr['subtitle'];
	$location = $item['deck'];
	$date = $current_year = date('m.d.Y', strtotime($item['begin']));
	$time = $current_year = date('H:i', strtotime($item['begin']));
	$event_media = $oo->media($item['id']);
	$landingImg_src = getEventThumbnail($event_media);
	$body_arr = prepareBody($item['body']);
?>
<div id = 'detail-container' class = 'main-container' eventType='<?= $thisEventType; ?>'>
	<section id = 'detail-header'>
		<? if(!empty($event_tag_arr)){
			foreach($event_tag_arr as $tag)
			{
				echo '<p class = "event-tag caption-roman fade-img-zone">'.$tag.'</p>';
			}
		} ?>
		<h1 id = 'event-title' class = 'event-title-large fade-img-zone'><?= $event_title; ?></h1>
		<?= empty($event_subtitle) ? '' : '<p id = "event-subtitle" class = "body-bold fade-img-zone">'.$event_subtitle.'</p>' ; ?>
		<?= empty($location) ? '' : '<p class = "body-bold event-location fade-img-zone">'.$location.'</p>' ; ?>
		<div id = 'event-time-ctner' class = 'fade-img-zone'>
			<p class = 'event-date date-small'><?= $date; ?></p>
			<p class = 'event-time date-small'><?= $time; ?></p>
		</div>
		<?= empty($landingImg_src) ? '' : '<img id="event-landingImg" src = "'. $landingImg_src .'">' ; ?>
	</section>
	<section id = 'detail-body' class = 'body-roman'>
		<? foreach($body_arr as $key => $b){
			?><div class = 'body-section'>
				<h2 class = 'section-title date-small text-outline'><?= $b['sectiontitle']; ?></h2>
				<div class = 'section-content'><p class='body-roman'><?= $b['content']; ?></p></div>
			</div><?
		} ?>
	</section>
</div>

<!-- <script type = "text/javascript" src = "/static/js/imgXTracking_controller.js"></script> -->
