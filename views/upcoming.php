<div id = "main_ctner_upcoming" class = "main_ctner">
	<div id = "title_title" class = "section_title">
		<h6 id = "cato"><? echo $thisEvent["cato"];  ?></h6>
		<h4 id = "title"><? echo $thisEvent["name1"]; ?></h4>
	</div>
	<div id = "title_content" class = "section_content"></div>
	<div id = "info_title" class = 'section_title'>
		<h6 class = "info_cato" id = "info_cato_time">Time</h6>
		<h6 class = "info_cato" id = "info_cato_location">Location</h6>
	</div>
	<div id = "info_content" class = "section_content">
		<h1 id = "info_time"><? 
			echo date('m.d.Y', strtotime($thisEvent['event_date']));  
			?><br><?
			echo $thisEvent['event_time'];  
			?>
		</h1>
		<div id = "info_location" class = "">
			<? foreach($thisEvent_location as $location){ ?>
				<h1 class = 'location'><? echo $location['loc']; ?><br><span class = "location_address"><? echo $location['address']; ?></span>
				</h1>
			<? } ?>
		</div>
	</div>
	<div id = "about_title" class = 'section_title'>
		<h6 class = "info_cato">About the artist</h6>
	</div>	
	<div id = "about_content" class = "section_content bodyText">
		<figure class = "about_img img_ctner">
			<img src = '<? echo $thumbnail_img; ?>' >
			<figcaption><? echo $thumbnail_caption; ?></figcaption>
		</figure>
		<div id = 'about_text'><? echo $thisEvent["upcoming_text"]; ?></div>
	</div>
	<div id = "reference_title" class = 'section_title'>
		<h6 class = "info_cato" id = "cato_website"></h6>
		<h6 class = "info_cato" id = "cato_exhibit"><? echo $hasExhibit ? 'Recent exhibition' : ''; ?></h6>
		<h6 class = "info_cato" id = "cato_reading"><? echo $hasReading ? 'Reading List' : ''; ?></h6>
	</div>
	<div id = "reference_content" class = "section_content">
		<div id = "reference_website">
			<? echo $thisEvent['website']; ?>
		</div>
		<div id = "reference_exhibit">
			<? echo $thisEvent['exhibit']; ?>
		</div>
		<div id = "reference_reading">
			<? echo $thisEvent['reading']; ?>
		</div>
	</div>
</div>
