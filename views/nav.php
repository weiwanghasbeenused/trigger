<div id = "nav" class = "<? echo ($uri[1] == "") ? "" : "folded" ?>">
	<div id = "title" >
		<h1 class = 'logo_explodeCtner'><svg class = 'explode' viewBox = '0 0 200 300'><polygon fill = '#fff' points = '121.5 140.5 200 70 105.24 129.71 147.81 0 86.5 116.5 78.5 43.5 74.18 131.45 14.5 58.5 58.5 148.5 2.5 144.5 54.5 169.5 0 220.14 55.93 187.49 8.8 300 75.5 206.5 83.5 260.5 92.5 195.5 179.5 278.5 114.5 183.5 157.5 195.5 118.5 162.5 183.07 140.92 121.5 140.5'></svg><a href = "/">Trigger</a></h1>
	</div>
	<div id = "menu_ctner">
		<? foreach($menu_items as $mi){ 
			$this_name = $mi['name1'];
			$this_url = strtolower($mi['url']);
		?>
			<div id = "menu_btn_<? echo $this_url; ?>" class = "menu_btn" >

				<a class = "<? 
					if($this_name == 'Events') echo ($uri[1] == $this_url || $uri[1] == '') ? 'active' : '' ;
					else echo ($uri[1] == $this_url) ? 'active' : '' ; 
					?> explodeCtner"  href = "/<? echo $this_url; ?>">
					<svg class = 'explode'></svg><? echo $mi['name1'] ?>
				</a>
				<? if(isset($mi['submenu'])){ 
						foreach($mi['submenu'] as $si){ 
							$this_sub_name = $si['name1'];
							$this_sub_url = strtolower($si['url']);
							?>
							<a class = "<? echo ($uri[2] == $this_sub_url) ? 'active' : '' ?> explodeCtner"  href = "/<? echo $this_url; ?>/<? echo $this_sub_url; ?>">
								<svg class = 'explode'></svg>&nbsp;|&nbsp;<? echo $this_sub_name; ?>&nbsp;</a>
					<? } ?>
				<? } ?>
			</div>
		<? } ?>
		<!-- <div id = "menu_layer1" class = "menu">
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
		</div> -->
	</div>
</div>




