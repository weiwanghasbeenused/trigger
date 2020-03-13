<div id = "nav" class = "<? echo ($uri[1] == "") ? "" : "folded" ?>">
	<div id = "title">
		<h1>Trigger</h1>
		<div class = "ex ex_initial"></div>
	</div>
	<div id = "menu_cnter">
		<div id = "menu_layer1" class = "menu">
			<h2 id = "menu_btn_event" class = "menu_btn_1 <? echo ($uri[1] == "events" || $uri[1] == "") ? "active" : "" ?>">Events</h2>
			<h2 id = "menu_btn_resource" class = "menu_btn_1 <? echo ($uri[1] == "resource") ? "active" : "" ?>">Resource</h2>
			<h2 id = "menu_btn_about" class = "menu_btn_1 <? echo ($uri[1] == "about") ? "active" : "" ?>">About</h2>
		</div>
	</div>
	<div id = "submenu_cnter" class = "menu submenu">
		<h2 id = "menu_btn_upcoming" class = "menu_btn_2 <? echo ($uri[2] == "upcoming") ? "active" : "" ?>">Upcoming</h2>
		<h2 id = "menu_btn_archive" class = "menu_btn_2 <? echo ($uri[2] == "archive") ? "active" : "" ?>">Archive</h2>
	</div>
</div>




