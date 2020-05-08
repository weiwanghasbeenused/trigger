<div id = "main_ctner_artist-index" class = "main_ctner <? echo $isSearch ? 'viewing_search' : '' ?>">
	<? require_once('controller/search_controller.php'); ?>
	<div id = 'no_result'><? echo $noResult ? 'No matched results found<br>Please try other keywords or reset search.' : ''; ?></div> 
	<div id = 'artist-index_list'>
	<? foreach($index_list as $list_item) { ?>
		<div class = 'artist-index_item explodeCtner_click'>
			<svg class = 'explode'></svg>
			<h4 class = 'item_name'><? echo $list_item['name']; ?></h4>
			<div class = 'item_tag'><? echo $list_item['tag']; ?></div>
			<div class = 'item_link'><? echo $list_item['link']; ?><br><? echo $list_item['exhibit']; ?></div>
			<div class = 'item_brief'><? echo $list_item['brief']; ?></div>
			
			
		</div>
	<? } ?>
	</div>
</div>