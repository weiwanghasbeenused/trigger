<div id = "nav" class = "<? echo ($uri[1] == "") ? "" : "folded" ?>">
	<div id = "title">
		<h1><a href = "/">Trigger</a></h1>
		<div class = "ex ex_initial"></div>
	</div>
	<div id = "menu_cnter">
		<div id = "menu_layer1" class = "menu">
			<div id = "menu_btn_event" class = "menu_btn" >
				<a class = "<? echo ($uri[1] == "events" || $uri[1] == "") ? "active" : "" ?> explodeCtner"  href = "/events">
					<svg class = 'explode'></svg>Events</a>
				<a class = "<? echo ($uri[2] == "upcoming") ? "active" : "" ?> explodeCtner"  href = "/events/upcoming">
					<svg class = 'explode'></svg>&nbsp;|&nbsp;Upcoming&nbsp;</a>
				<a class = "<? echo ($uri[2] == "archive") ? "active" : "" ?> explodeCtner"  href = "/events/archive">
					<svg class = 'explode'></svg>&nbsp;|&nbsp;Archive&nbsp;</a>
			</div>
			<div id = "menu_btn_resource" class = "menu_btn" >
				<a id = "menu_btn_resource" class = "<? echo ($uri[1] == "resource") ? "active" : "" ?> explodeCtner" href = "/resource"><svg class = 'explode'></svg>Resource<br></a>
			</div>
			<div id = "menu_btn_about" class = "menu_btn" >
				<a id = "" class = "<? echo ($uri[1] == "about") ? "active" : "" ?> explodeCtner" href = "/about"><svg class = 'explode'></svg>About</a>
			</div>
		</div>
	</div>
</div>




