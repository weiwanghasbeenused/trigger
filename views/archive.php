<div id = "main_ctner_archive" >
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
	<div id = "intro_content" class = "section_content"><? echo $thisEvent['body']; ?></div>
	<div class = "section_title">
		<h6>Q&A</h6>
		<h6>w/ {{thisEvent.event_qa[0]}}, translater/ {{thisEvent.event_qa[1]}}</h6>
	</div>
	<div id = "qa" class = "section_content">
		<div class = "content_section">
			<p class = "body">
				DevolutioN Architecture was founded in 2016 and it consists of three members: Tang Jiansong, Wang Qi and Yang Lutong. It is a “Triple-A Company” committed to involvements in “Architecture, Art, and Advertisement”. At the same time, DevolutioN Architecture strives to connect architecture with other mediums, creating incidents in different environments through the logic of architecture and the methods of art production. 
			</p>
			<div class = "img_ctner">
				<img src = "asset/images/event/DevolutioN_Small.jpg">
				<p class = "caption">Members of DevolutioN Architecture. From the left: Wang Qi, Tang Jiansong, Yang Lutong</p>
			</div>
			<p class = "body">
				Till now, China has experienced roughly 30 years of rapid developments in the real estate industry as well as the design industry. Now, both industries face a need to rethink their target audiences and the question of how to further upgrade themselves. Here, I will share DevolutioN Architecture’s thoughts on these issues.
			</p>
			<p class = "body">
				Till now, China has experienced roughly 30 years of rapid developments in the real estate industry as well as the design industry. Now, both industries face a need to rethink their target audiences and the question of how to further upgrade themselves. Here, I will share DevolutioN Architecture’s thoughts on these issues.
			</p>
			<p class = "body">
				Till now, China has experienced roughly 30 years of rapid developments in the real estate industry as well as the design industry. Now, both industries face a need to rethink their target audiences and the question of how to further upgrade themselves. Here, I will share DevolutioN Architecture’s thoughts on these issues.
			</p>
		</div>
	</div>
</div>