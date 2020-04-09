<div id = "main_ctner_archive" class = "main_ctner">
	<div id = "title_title" class = "section_title">
		<h6 id = "cato"><? echo $thisEvent["cato"];  ?></h6>
		<h4 id = "title"><? echo $thisEvent["name1"]; ?></h4>
		<div id = "info">
			<h6 id = "time"><? 
			echo date('m.d.Y', strtotime($thisEvent['event_date']));  
			?> <?
			echo $thisEvent['event_time'];  
			?></h6>
			<h6 id = "location">Multiple locations</h6>
		</div>
	</div>
	<div id = "intro_content" class = "section_content bodyText"><? echo $thisEvent['body']; ?></div>
	<? if(!empty($thisEvent["qanda"])){ ?>
		<div id = "qanda_title" class = "section_title">
			<h6>Q&A</h6>
		</div>
		<div id = "qanda_content" class = "section_content bodyText">
			<? echo $thisEvent["qanda"]; ?>
		</div>
	<? } ?>
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
			<? echo $thisEvent['exhibit']; ?>
		</div>
		<div id = "reference_reading">
			<? echo $thisEvent['reading']; ?>
		</div>
	</div>
</div>