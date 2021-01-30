<?
	$artist_index_children = $oo->children($item['id']);
?>
<main class = 'main-container'>
	<div id = 'artist-index-container' class = ''>
		<? if(!empty($artist_index_children)){
		foreach($artist_index_children as $child){
			$artist_name = $child['name1'];
			$artist_tag_raw = $child['deck'];
			$artist_tag = '';
			if(!empty($artist_tag_raw))
			{
				$artist_tag_raw = explode(',', $artist_tag_raw);	
				foreach($artist_tag_raw as $key => &$tag){
					while(substr($tag, 0, 1) == ' ')
						$tag = substr($tag, 1);
					$artist_tag .= '<div class = "tag">' . $tag . '</div>';
					if($key < count($artist_tag_raw) -1 )
						$artist_tag .= '<br>';
				}
			}
			
			$artist_notes = $child['notes'];
			$artist_brief = $child['body'];
			?><div class = 'artist-index_item explodeCtner_click'>
			<svg class = 'explode'></svg>
			<h3 class = 'artist-name body-bold'><?= $artist_name; ?></h3><div class = 'artist-tag-container caption-roman'>
				<?= $artist_tag; ?></div><div class = 'artist-notes caption-roman'>
				<?= $artist_notes; ?></div><div class = 'artist-brief caption-roman'>
				<?= $artist_brief; ?></div>
		</div><?
		}} ?>
	</div>
</main>
<script>
	var sArtist_index_item = document.getElementsByClassName('artist-index_item');
	if(sArtist_index_item.length > 0)
	{	
		console.log('>0');
		[].forEach.call(sArtist_index_item, function(el, i){
			el.addEventListener('click', function(){
				console.log('click');
				el.classList.toggle('expanded');
			});
		});
	}
	
</script>
