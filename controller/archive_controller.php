<?
$ee = new Events();
$thisEvent = $item;
$thisEvent_media = $ee->media($uu->id);
$this_cat = $thisEvent["cato"];
$this_title = $thisEvent["name1"];
$this_location = $thisEvent["location"];
$this_date = date("m. d. Y", strtotime($thisEvent["event_date"]));
$this_time = date("H: i", strtotime($thisEvent["event_time"]));
$this_main2 = $thisEvent["main_two"];
$this_qanda = $thisEvent["qanda"];

$imgUrl = array();

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

foreach($thisEvent_media as $m)
	array_push($imgUrl, "/media/" . m_pad($m['id']).".".$m['type']); 
require_once("views/archive.php");
?>

<script type = "text/javascript" src = "/controller/sectioning.js"></script>
<script type = "text/javascript" src = "/scripts/scrollEvents.js"></script>
<script type = "text/javascript" src = "/scripts/foldTitle.js"></script>
<script>
	var titleIsFolded = false;
	var topElement = document.getElementById("nav");
	var title_height = document.getElementById("cato").clientHeight;
	var sTitle_title = document.getElementById("title_title");
	sTitle_title.style.height = title_height+10+'px'
	sectioning_title(topElement);

	window.addEventListener('scroll', function(){
		sTop = window.scrollY;
		if (!ticking) {
		    window.requestAnimationFrame(function() {
	    		if(sTop >= 100 && !titleIsFolded){
				  	sTitle_title.classList.add("folded");
				  	sTitle_title.addEventListener('transitionend', function(){
				  		titleIsFolded = true;
				  	});
				}else if(sTop < 1 && titleIsFolded){
				  	sTitle_title.classList.remove("folded");
				  	sTitle_title.addEventListener('transitionend', function(){
				  		titleIsFolded = false;
				  	});
				}
		      	ticking = false;
		    });

		    ticking = true;
		}
	});

	var sImg_ctner_temp = document.getElementsByClassName('img_ctner_temp');
	for(i = 0 ; i< sImg_ctner_temp.length; i++){
		var thisParent = sImg_ctner_temp[i].parentElement;
		var thisImg_ctner = document.createElement('figure');
		var caption = sImg_ctner_temp[i].getAttribute('caption');
		var thisCaption = document.createElement('figcaption');
		thisCaption.innerText = caption;
		thisImg_ctner.className = 'img_ctner';
		thisParent.insertBefore(thisImg_ctner, sImg_ctner_temp[i])
		thisImg_ctner.appendChild(sImg_ctner_temp[i]);
		thisImg_ctner.appendChild(thisCaption);
		sImg_ctner_temp[i].className = '';
	}
	// intro_content
	var sIntro_content = document.getElementById('intro_content');
	var children = sIntro_content.children;
	var temp = document.createElement('div');
	var temp_intro_content = document.createElement('div');
	temp.className = 'content_section';
	var fuse = 0;
	while(children.length && fuse < 300){
		if(children[0].classList.contains('subtitle')){
			temp_intro_content.appendChild(temp);
			var temp = document.createElement('div');
			temp.className = 'content_section';
		}
		temp.appendChild(children[0]);
		fuse++;
	}
	if(fuse == 300){
		console.log('loop loses control (or we do have 300 paragraphs)');
	}
	temp_intro_content.appendChild(temp);
	sIntro_content.innerHTML = temp_intro_content.innerHTML;
</script>

