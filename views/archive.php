<div id = "main_ctner_archive" class = "main_ctner">
	<div id = "title_title" class = "section_title">
		<h6 id = "cato"><? echo $this_cat;  ?></h6>
		<h4 id = "title"><? echo $this_title; ?></h4>
		<div id = "info">
			<h6 id = "time"><? echo $this_date.'&nbsp;&nbsp;'.$this_time; ?></h6>
			<h6 id = "location"><? echo $this_location; ?></h6>
		</div>
	</div>
	<div id = "intro_content" class = "section_content bodyText"><? echo $this_main2; ?></div>
	<? if(!empty($this_qanda)){ ?>
		<div id = "qanda_title" class = "section_title">
			<h6>Q&A</h6>
		</div>
		<div id = "qanda_content" class = "section_content bodyText">
			<? echo $this_qanda; ?>
		</div>
	<? } 

	if($hasReference){
	?>
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
	<? } ?>
</div>