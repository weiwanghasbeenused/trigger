<div id = "main_ctner_upcoming" class = "main_ctner">
	<div id = "title_title" class = "section_title">
		<h6 id = "cato"><? echo $this_cat;  ?></h6>
		<h4 id = "title"><? echo $this_title; ?></h4>
	</div>
	<div class = 'section'>
		<div id = "title_content" class = "section_content"></div>
		<div id = "info_title" class = 'section_title'>
			<h6 class = "info_cato" id = "info_cato_time">Time</h6>
			<h6 class = "info_cato" id = "info_cato_location">Location</h6>
		</div>
		<div id = "info_content" class = "section_content">
			<div id = "info_time"><? 
				echo $this_date;  
				?><br><?
				echo $this_time;
				?>
			</div>
			<div id = "info_location" class = "">
				<? echo $this_location; ?>
			</div>
		</div>
	</div>
		<div class = 'section'>
		<div id = "about_title" class = 'section_title'>
			<h6 class = "info_cato">About the event</h6>
		</div>	
		<div id = "about_content" class = "section_content bodyText">
			<figure class = "about_img img_ctner">
				<img src = '<? echo $thumbnail_img; ?>' >
				<figcaption><? echo $thumbnail_caption; ?></figcaption>
			</figure>
			<div id = 'about_text'><? echo $this_main1; ?></div>
		</div>
	</div>
	<? if($hasReference){ ?>
	<div class = 'section'>
		<div id = "reference_title" class = 'section_title'>
			<h6 class = "info_cato" id = "cato_website"><? echo $hasWebsite ? 'Website' : ''; ?></h6>
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
	<? } ?>
</div>
