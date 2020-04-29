<?
$ee = new Events();
$thisEvent = $item;
$thisEvent_media = $ee->media($uu->id);
$this_cat = $thisEvent["cato"];
$this_title = $thisEvent["name1"];
$this_location = $thisEvent["location"];
$this_date = $thisEvent["event_date"];
$this_time = $thisEvent["event_time"];
$this_main1 = $thisEvent["main_one"];


$imgUrl = array();
$thumbnail_img = $thisEvent['thumbnail'];
$thumbnail_filename = end(explode('/', $thumbnail_img));
$thumbnail_filename = explode('.', $thumbnail_filename)[0];
$thumbnail_caption;


$hasExhibit = false;
$hasReading = false;
$hasWebsite = false;
$hasReference = true;
if($thisEvent['exhibit'])
	$hasExhibit = true;
if($thisEvent['reading'])
	$hasReading = true;
if($thisEvent['website'])
	$hasWebsite = true;
if(!$hasExhibit && !$hasReading && !$hasWebsite)
	$hasReference = false;
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
