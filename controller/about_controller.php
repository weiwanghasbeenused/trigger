<?
$ee = new Events();
$media = $ee->media($uu->id);

$bodyText = $item['upcoming_text'];
 
require_once("views/about.php");
?>
<script type = "text/javascript" src = "/controller/sectioning.js"></script>
<script>
	var sIntro_content = document.getElementById('main_ctner_about');
	var children = sIntro_content.children;
	var temp = document.createElement('div');
	var temp_intro_content = document.createElement('div');
	temp.className = 'section_content';
	var fuse = 0;
	while(children.length && fuse < 300){
		if(children[0].classList.contains('subtitle')){
			temp_intro_content.appendChild(temp);
			var temp = document.createElement('div');
			var temp_title = document.createElement('h6');
			temp.className = 'section_title';
			temp_title.innerText = children[0].innerText;
			temp.appendChild(temp_title);
			temp_intro_content.appendChild(temp);
			children[0].parentNode.removeChild(children[0]);

			var temp = document.createElement('div');
			temp.className = 'section_content';
		}else{
			temp.appendChild(children[0]);
		}
		fuse++;
	}
	if(fuse == 300){
		console.log('loop loses control (or we do have 300 paragraphs)');
	}
	temp_intro_content.appendChild(temp);
	sIntro_content.innerHTML = temp_intro_content.innerHTML;

	var topElement = document.getElementById("nav"); 
	sectioning_title(topElement);
</script>

