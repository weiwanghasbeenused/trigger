<?
$ee = new Events();
$thisEvent = $item;
$thisEvent_media = $ee->media($uu->id);
$thisEvent_location = $ee->get_location($thisEvent["location"]);
$imgUrl = array();
// push relative paths
foreach($thisEvent_media as $m)
	array_push($imgUrl, "/media/" . m_pad($m['id']).".".$m['type']); 
require_once("views/upcoming.php");
?>

<script type = "text/javascript" src = "/controller/sectioning.js"></script>
<script type = "text/javascript" src = "/scripts/scrollEvents.js"></script>
<script type = "text/javascript" src = "/scripts/foldTitle.js"></script>
<script>
	var topElement = document.getElementById("nav"); 
	sectioning_title(topElement);
	scrollEvents(foldTitle);
</script>
