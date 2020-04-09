<div id = "main_ctner_resource" class = "main_ctner main_ctner_list">
	<? foreach($resource_list as $key => $rl){ ?>
		<div class = 'resource_item'>
			<? echo $rl; ?>
			<? if($resource_from_name[$key] != null){ ?>
			<div class = 'item_events'>
				<p>relevent events:</p>
				<? foreach( $resource_from_name[$key] as $k => $rfn ){ ?>
				<a class = "events_name" href = '<? echo $resource_from_link[$key][$k]; ?>'><? echo $rfn; ?></a><br>
				<? } ?>
			</div>
			<? } ?>
		</div>
	<? } ?>
</div>
