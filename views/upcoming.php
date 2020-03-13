<div id = "main_ctner_upcoming" >
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
			<? foreach($thisEvent_location as $key => $val){ ?>
				<h1 class = 'location'><? echo $key; ?><br><span class = "location_address"><? echo $val; ?><span>
				</h1>
			<? } ?>
		</div>
	</div>
	<div id = "about_title" class = 'section_title'>
		<h6 class = "info_cato">About the artist</h6>
	</div>	
	<div id = "about_content" class = "section_content">
		<div id = "about_img" class = "img_ctner">
			<img  src = "<? echo $imgUrl[0]; ?>">
			<p class = "caption"></p>
		</div>
		<div id = "about_bio">
			<p class = "body"><? echo $thisEvent["upcoming_text"]; ?></p>
		</div>
	</div>
	<div id = "reference_title" class = 'section_title'>
		<h6 class = "info_cato" id = "cato_website">Artist&rsquo;s website</h6>
		<h6 class = "info_cato" id = "cato_exhibit">Recent exhibition</h6>
		<h6 class = "info_cato" id = "cato_reading">Reading list</h6>
	</div>	
	<div id = "reference_content" class = "section_content">
		<div id = "reference_website">
			<? echo $thisEvent['website']; ?>
		</div>
		<div id = "reference_exhibit">
			<!-- <a ng-repeat = "exhibit in thisEvent.event_artistexhibit" class = "link_exhibit" href = "{{exhibit[2]}}">
				<div class = "exhibit_title"><? echo $thisEvent["website"];?></div><div class = "exhibit_info"><? echo exhibit[1]?></div>
			</a> -->
		</div>
		<div id = "reference_reading"></div>
	</div>
</div>
