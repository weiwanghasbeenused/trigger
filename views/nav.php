<?
$menu_items = $oo->children(0);
foreach($menu_items as $key => $mi){
	if(substr($mi['name1'], 0, 1) == '.')
		unset($menu_items[$key]);
$menu_items = array_values($menu_items);
}
?>
<div id = "title" >
	<h1 class = 'body-medium logo_explodeCtner'>
		<svg class = 'explode' viewBox = '0 0 200 300'><polygon fill = '#fff' points = '121.5 140.5 200 70 105.24 129.71 147.81 0 86.5 116.5 78.5 43.5 74.18 131.45 14.5 58.5 58.5 148.5 2.5 144.5 54.5 169.5 0 220.14 55.93 187.49 8.8 300 75.5 206.5 83.5 260.5 92.5 195.5 179.5 278.5 114.5 183.5 157.5 195.5 118.5 162.5 183.07 140.92 121.5 140.5'></polygon></svg>
		<a href = "/">Trigger</a>
	</h1>
</div>
<div id = "nav-toggle">
	<div class = "nav-toggle-bar"></div>
	<div class = "nav-toggle-bar"></div>
	<div class = "nav-toggle-bar"></div>
</div>
<div id = "nav" class = "">
	<div id = "menu_ctner">
		<? foreach($menu_items as $mi){ 
			$this_name = $mi['name1'];
			$this_url = strtolower($mi['url']);
		?>
			<div id = "menu_btn_<? echo $this_url; ?>" class = "menu_btn" >
				<a class = "event-title-large <? echo ($uri[1] == $this_url) ? 'active' : '' ; ?> explodeTrigger"  href = "/<? echo $this_url; ?>" triggerType="hover">
					<div class = "explodeCtner"><svg class = 'explode'></svg></div><? echo $mi['name1'] ?>
				</a>
			</div><br>
		<? } ?>
	</div>
</div>
<script>
	var sNav_toggle = document.getElementById('nav-toggle');
	sNav_toggle.addEventListener('click', () => document.body.classList.toggle('viewingNav'));
</script>




