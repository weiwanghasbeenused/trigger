<?
$ee = new Events();
$upcoming_events = $ee->get_upcoming();
$archive_events = $ee->get_archive();
$upcoming_events_media = $oo->media($upcoming_events[0]['id']);
$upcoming_tn_url = array();
$archive_tn_url = array();
foreach($upcoming_events as $up){
	$upcoming_tn_url[$up['id']] = $oo->media($up['id'])[0];
}
foreach($archive_events as $ar){
	$archive_tn_url[$ar['id']] = $oo->media($ar['id'])[0];
}
require_once("views/home.php");
?>
<script type = "text/javascript" src = "/scripts/foldNav.js"></script>
<script type = "text/javascript" src = "/scripts/scrollEvents.js"></script>
<script>
	scrollEvents(foldNav);
</script>