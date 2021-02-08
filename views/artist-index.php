<?
	$artist_index_children = $oo->children($item['id']);
?>
<main class = 'main-container padding-container'>
	<div id = 'artist-index-container' class = ''>
		<? if(!empty($artist_index_children)){
		foreach($artist_index_children as $key => $child){
			if(substr($child['name1'], 0, 1) !== '.'){
				$artist_name = $child['name1'];
				$artist_tag_raw = $child['deck'];
				$artist_tag = '';
			
				
				if(!wysiwygEmpty($artist_tag_raw))
				{
					$artist_tag_raw = explode(',', $artist_tag_raw);	
					foreach($artist_tag_raw as $key => &$tag){
						while(substr($tag, 0, 1) == ' ')
							$tag = substr($tag, 1);
						$artist_tag .= '<div class = "tag">' . $tag . '</div>';
					}
				}
				
				$artist_notes = $child['notes'];
				$artist_brief = $child['body'];
				?><div class = 'artist-index_item explodeTrigger' triggerType = 'click'>
				<div class = 'explodeCtner'><svg class = 'explode'></svg></div>
				<h3 class = 'artist-name body-bold'><?= $artist_name; ?></h3><div class = 'artist-tag-container caption-roman'>
					<?= $artist_tag; ?></div><div class = 'artist-notes caption-roman'>
					<?= $artist_notes; ?></div><div class = 'artist-brief body-roman'>
					<?= $artist_brief; ?></div>
				<a class = 'btn-fold-artist-item body-bold'>&#8593;</a>
				<div class = 'artist-index_item-expand-zone'></div>
			</div><?
		}}} ?>
	</div>
</main>
<script>
	var sArtist_index_item = document.getElementsByClassName('artist-index_item');
	if(sArtist_index_item.length > 0)
	{	
		[].forEach.call(sArtist_index_item, function(el, i){
			var this_expand_zone = el.querySelector('.artist-index_item-expand-zone');
			this_expand_zone.addEventListener('click', function(){
				if(!el.classList.contains('expanded'))
					el.classList.toggle('expanded');
			});
			var this_fold_btn = el.querySelector('.btn-fold-artist-item');
			this_fold_btn.addEventListener('click', function(){
				el.classList.remove('expanded');
			});
		});
	}
</script>
