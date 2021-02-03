<?
if(count($uri) < 3)
{
	$eventType = false;
	$items = array(
		array( 
			'name1' => 'upcoming',
			'url' => 'upcoming'
		),
		array( 
			'name1' => 'archive',
			'url' => 'archive'
		)
	);
}
else
{
	$eventType = end($uri);
	$eventType_id = end($oo->urls_to_ids(array($eventType)));
	$sql = "SELECT objects.id, objects.name1, objects.begin, objects.url FROM objects, wires WHERE objects.active='1' AND wires.active='1' AND objects.name1 NOT LIKE '.%' AND objects.id = wires.toid AND wires.fromid = '".$eventType_id."' ORDER BY objects.begin DESC";
	$res = $db->query($sql);
    if(!$res)
		throw new Exception($db->error);
	$items = array();
	while ($obj = $res->fetch_assoc())
		$items[] = $obj;
	$res->close();

}
?>

<section id = 'main'>
	<? if(count($uri) == 3){
		?><div id ='action-list'><a class = 'btn-action' href = '/events-manager/<?= $eventType; ?>/add'>ADD...</a></div><?
	} ?>
	<ul id = 'list' <?= $eventType ? 'eventType="'.$eventType.'"' : '' ?> >
	<?
		foreach($items as $item)
		{
			$name1 = $item['name1'];
			$tag = '';
			$tagdivider = '[tagdivider]';
			$tagdivider_pos = strpos($name1, $tagdivider);
			if($tagdivider_pos){
				$tag = substr($name1, 0, $tagdivider_pos);
				$name1 = substr($name1, $tagdivider_pos + strlen($tagdivider));
			}
			$subtitle = '';
			$subtitledivider = '[subtitledivider]';
			$subtitledivider_pos = strpos($name1, $subtitledivider);
			if($subtitledivider_pos){
				$subtitle = substr($name1, $subtitledivider_pos + strlen($subtitledivider));
				$name1 = substr($name1, 0, $subtitledivider_pos);
			}
			$title = $name1;
			if($eventType){
				$url = '/events-manager/'.$eventType.'/'.$item['url'].'/edit';
				$url_delete = '/open-records-generator/delete/'.$eventType.'/'.$item['url'];
			}
			else{
				$url = '/events-manager/'.$item['url'];
				$url_delete = '';
			}
			?><li class = '<?= $tag; ?>'><a class = 'btn-delete btn-action' href = '<?= $url_delete; ?>'>delete</a><a class = 'btn-edit' href = '<?= $url; ?>'><?= $title; ?><?= empty($title) ? '' : '<br>' . $subtitle; ?></a></li><?
		}
	?>
	</ul>
</section>
<footer></footer>