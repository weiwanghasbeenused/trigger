<div id = "nav" class = "<? echo ($uri[1] == "") ? "" : "folded" ?>">
	<div id = "title">
		<h1><a href = "/">Trigger</a></h1>
		<div class = "ex ex_initial"></div>
	</div>
	<div id = "menu_cnter">
		<div id = "menu_layer1" class = "menu">
			<div id = "menu_btn_event" class = "menu_btn" ><a class = "<? echo ($uri[1] == "events" || $uri[1] == "") ? "active" : "" ?>"  href = "/events">Events</a><a class = "<? echo ($uri[2] == "upcoming") ? "active" : "" ?>"  href = "/events/upcoming">&nbsp;|&nbsp;Upcoming&nbsp;</a><a class = "<? echo ($uri[2] == "archive") ? "active" : "" ?>"  href = "/events/archive">&nbsp;|&nbsp;Archive&nbsp;</a></div>
			<a id = "menu_btn_resource" class = "menu_btn <? echo ($uri[1] == "resource") ? "active" : "" ?>" href = "/resource">Resource</a>
			<a id = "menu_btn_about" class = "menu_btn <? echo ($uri[1] == "about") ? "active" : "" ?>" href = "/about">About</a>
		</div>
	</div>
</div>




