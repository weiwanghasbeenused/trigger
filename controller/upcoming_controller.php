<?
$ee = new Events();
$thisEvent = $item;
$thisEvent_media = $ee->media($uu->id);
$thisEvent_location = $ee->get_location($thisEvent["location"]);
$imgUrl = array();
$thumbnail_img = $thisEvent['thumbnail'];
$thumbnail_filename = end(explode('/', $thumbnail_img));
$thumbnail_filename = explode('.', $thumbnail_filename)[0];
$thumbnail_caption;

// push relative paths
foreach($thisEvent_media as $m){
	$this_filename = "".m_pad($m['id']);
	if($m['id'] == $thumbnail_filename){
		if(isset($m['caption'])){
			$thumbnail_caption = $m['caption'];
		}else{
			$thumbnail_caption = "";
		}
	}
}
if(empty($thisEvent_location)){
	$thisEvent_location = array();
}
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
