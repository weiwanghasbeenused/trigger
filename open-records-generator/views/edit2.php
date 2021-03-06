<script type = "text/javascript" src = '<? echo $admin_path;?>static/wysiwyg_func.js'></script>
<?
$browse_url = $admin_path.'browse/'.$uu->urls();

$vars = array("cato", "name1", "event_date", "event_time", "location", "upcoming_text", "website", "exhibit", "reading", "body", "url", "rank", "qanda", "begin", "end","thumbnail" );

$var_info = array();

$var_info["input-type"] = array();
$var_info["input-type"]["name1"] = "text";
$var_info["input-type"]["body"] = "triggerEditor";
$var_info["input-type"]["qanda"] = "triggerEditor";
$var_info["input-type"]["begin"] = "text";
$var_info["input-type"]["end"] = "text";
$var_info["input-type"]["url"] = "text";
$var_info["input-type"]["rank"] = "text";
$var_info["input-type"]["event_date"] = "text";
$var_info["input-type"]["event_time"] = "text";
$var_info["input-type"]["location"] = "text";
$var_info["input-type"]["cato"] = "text";
$var_info["input-type"]["upcoming_text"] = "triggerEditor";
$var_info["input-type"]["website"] = "referencelist";
$var_info["input-type"]["exhibit"] = "referencelist";
$var_info["input-type"]["reading"] = "referencelist";
$var_info["input-type"]["thumbnail"] = "none";

$var_info["label"] = array();
$var_info["label"]["cato"] = "Event Category";
$var_info["label"]["name1"] = "Title";
$var_info["label"]["event_date"] = "Date";
$var_info["label"]["event_time"] = "Time";
$var_info["label"]["location"] = "Location";
$var_info["label"]["upcoming_text"] = "Upcoming Intro";
$var_info["label"]["website"] = "Website";
$var_info["label"]["exhibit"] = "Recent Exhibition";
$var_info["label"]["reading"] = "Reading List";
$var_info["label"]["body"] = "Main Text";
$var_info["label"]["url"] = "URL Slug";
$var_info["label"]["rank"] = "Rank";
$var_info["label"]["qanda"] = "Q & A";
$var_info["label"]["begin"] = "Begin";
$var_info["label"]["end"] = "End";

// return false if object not updated,
// else, return true
function update_object(&$old, &$new, $siblings, $vars)
{
	global $oo;

	// set default name if no name given
	if(!$new['name1'])
		$new['name1'] = "untitled";

	// add a sort of url break statement for urls that are already in existence
	// (and potentially violate our new rules?)
	$url_updated = urldecode($old['url']) != $new['url'];

	if($url_updated)
	{
		// slug-ify url
		if($new['url'])
			$new['url'] = slug($new['url']);

		// if the slugified url is empty,
		// or the original url field is empty,
		// slugify the name of the object
		if(empty($new['url']))
			$new['url'] = slug($new['name1']);

		// make sure url doesn't clash with urls of siblings

		$s_urls = array();
		foreach($siblings as $s_id)
			$s_urls[] = $oo->get($s_id)['url'];

		$new['url'] = valid_url($new['url'], strval($old['id']), $s_urls);
	}
	// deal with dates
	if(!empty($new['begin']))
	{
		$dt = strtotime($new['begin']);
		$new['begin'] = date($oo::MYSQL_DATE_FMT, $dt);
	}

	if(!empty($new['end']))
	{
		$dt = strtotime($new['end']);
		$new['end'] = date($oo::MYSQL_DATE_FMT, $dt);
	}
	if(!empty($new['event_date']))
	{
		$dt = strtotime($new['event_date']);
		$new['event_date'] = date("Y-m-d", $dt);
	}
	if(!empty($new['website'])){
		
	}

	// check for differences
	$arr = array();
	foreach($vars as $v)
		if($old[$v] != $new[$v])
			$arr[$v] = $new[$v] ?  "'".$new[$v]."'" : "null";

	$updated = false;
	if(!empty($arr))
	{
		$updated = $oo->update($old['id'], $arr);
	}


	return $updated;
}

?><div id="body-container">
	<div id="body"><?
	// TODO: this code is duplicated in
	// + add.php
	// + browse.php
	// + edit.php
	// + link.php
	// ancestors
	$a_url = $admin_path."browse";
	for($i = 0; $i < count($uu->ids)-1; $i++)
	{
		$a = $uu->ids[$i];
		$ancestor = $oo->get($a);
		$a_url.= "/".$ancestor["url"];
		?><div class="ancestor">
			<a href="<? echo $a_url; ?>"><? echo $ancestor["name1"]; ?></a>
		</div><?
	}
if ($rr->action != "update" && $uu->id)
{
	// get existing image data
	$medias = $oo->media($uu->id);
	$num_medias = count($medias);
	// add associations to media arrays:
	// $medias[$i]["file"] is url of media file
	// $medias[$i]["display"] is url of display file (diff for pdfs)
	// $medias[$i]["type"] is type of media (jpg, gif, pdf, mp4, mp3)
	for($i = 0; $i < $num_medias; $i++)
	{
		$m_padded = "".m_pad($medias[$i]['id']);
		$medias[$i]["file"] = $media_path.$m_padded.".".$medias[$i]["type"];
		if ($medias[$i]["type"] == "pdf")
			$medias[$i]["display"] = $admin_path."media/pdf.png";
		else if ($medias[$i]["type"] == "mp4")
			$medias[$i]["display"] = $admin_path."media/mp4.png";
		else if ($medias[$i]["type"] == "mp3")
			$medias[$i]["display"] = $admin_path."media/mp3.png";
		else
			$medias[$i]["display"] = $medias[$i]["file"];
	}

	$form_url = $admin_path."edit/".$uu->urls();
// object contents
?><div id="form-container">
		<div class="self">
			<a href="<? echo $browse_url; ?>"><? echo $name; ?></a>
		</div>
		<form
			method="post"
			enctype="multipart/form-data"
			action="<? echo $form_url; ?>"
		>
			<div class="form">
				<script>

				function link(name) {
						var linkURL = prompt('Enter a URL:', 'http://');
						if (linkURL === null || linkURL === "") {
							return;
						}

						document.execCommand('createlink', false, linkURL);
				}

				function addListeners(name) {
					document.getElementById(name + '-html').addEventListener('click', function(e) {resignImageContainer(name);}, false);
					document.getElementById(name + '-link').addEventListener('click', function(e) {resignImageContainer(name);}, false);
				}

				function resignImageContainer(name) {
					var imagecontainer = document.getElementById(name + '-imagecontainer');
					imagecontainer.classList.toggle('hidden');
				}
				function image(name) {
					var imagecontainer = document.getElementById(name + '-imagecontainer');
					var imagebox = document.getElementById(name + '-imagebox');
					imagecontainer.classList.toggle('hidden');
				}
				function insertImage(name, img){
					var editable = document.getElementById(name+"-editable");
					if(selectedGrandParentNodeOrder !==0){
						var targetElement = editable.childNodes[selectedGrandParentNodeOrder].childNodes[selectedParentNodeOrder];
					}else{
						var targetElement = editable.childNodes[selectedParentNodeOrder];
					}
					var target_html = targetElement.innerHTML;
					targetElement.innerHTML
				}

				function showToolBar(name) {
					// hideToolBars();
					// var tb = document.getElementById(name + '-toolbar');
					// tb.style.display = 'block';
				}

				function hideToolBars() {
					// var tbs = document.getElementsByClassName('toolbar');
					// Array.prototype.forEach.call(tbs, function(tb) { tb.style.display = 'none'});

					// var ics = document.getElementsByClassName('imagecontainer');
					// Array.prototype.forEach.call(ics, function(ic) { ic.style.display = 'none'});
				}

				function commitAll() {
					var names = <?
						$textnames = [];
						foreach($vars as $var) {
							if($var_info["input-type"][$var] == "textarea" || $var_info["input-type"][$var] == "triggerEditor" ) {
								$textnames[] = $var;
							}
						}
						echo '["' . implode('", "', $textnames) . '"]'
						?>;
					<?
					foreach($vars as $var) {
						if($var_info["input-type"][$var] == "triggerEditor" ) {
							?> 
							wrappingImgCtner('<? echo $var ?>'); <?
						}
					}

					?>

					for (var i = 0; i < names.length; i++) {
						commit(names[i]);
					}
				}
				function commit(name) {
					var editable = document.getElementById(name + '-editable');
					var textarea = document.getElementById(name + '-textarea');
					if (editable.style.display === 'block') {
						var html = editable.innerHTML;
						textarea.value = html;    // update textarea for form submit
					} else {
						var html = textarea.value;
						editable.innerHTML = html;    // update editable
					}
					// console.log([name, editable.style.display, textarea.style.display]);
				}

				function resetViews(name) {
					// commitAll();
					// var names = <?
					// 	$textnames = [];
					// 	foreach($vars as $var) {
					// 		if($var_info["input-type"][$var] == "textarea") {
					// 			$textnames[] = $var;
					// 		}
					// 	}
					// 	echo '["' . implode('", "', $textnames) . '"]'
					// 	?>;

					// for (var i = 0; i < names.length; i++) {
					// 	if (!(name && name === names[i]))
					// 		showrich(names[i]);
					// 	}
				}

				
				function addListItem(name){
					var field_body = document.getElementById(name+"-body"); 
					var order = document.querySelectorAll('#'+name+'-body .list_name').length+1;
					var newElements = [];
					newElements[0] = document.createElement("div");
					newElements[0].className = "list_name";
					newElements[0].innerText = name+'-'+order;
					newElements[1] = document.createElement("input");
					newElements[2] = document.createElement("input");
					newElements[1].name = name+"[]";
					newElements[2].name = name+"Url[]";
					newElements[1].type = "referencelist";
					newElements[2].type = "referencelist";
					newElements[1].value = '(title)';
					newElements[2].value = '(url)';
					for($i = 0 ; $i < newElements.length ; $i++){
						field_body.appendChild(newElements[$i]);
					}
					
				}
				
				</script>
				<?php
				// show object data
				foreach($vars as $var)
				{
				?><div class="field">
					<div class="field-name"><? echo $var_info["label"][$var]; ?></div>
					<div id = "<? echo $var; ?>-body" class = "field-body"><?
						if($var_info["input-type"][$var] == "textarea")
						{

                        // ** start experimental minimal wysiwig toolbar **

                        ?>

					<div id="<?echo $var;?>-toolbar" class="toolbar">
						<a id="<? echo $var; ?>-html" class='right tool_show' href="#null" onclick="sethtml('<? echo $var; ?>');">html</a>
						<a id="<? echo $var; ?>-txt" class='right tool_hide' href="#null" onclick="showrich('<? echo $var; ?>');">done.</a>
						<a id="<? echo $var; ?>-back" class='tool_show' href="#null" onclick="undo('<? echo $var; ?>');">Undo &#8617;</a>
						<a id="<? echo $var; ?>-forward" class='tool_show' href="#null" onclick="redo('<? echo $var; ?>');">&#8618; Redo</a>
						<a id="<? echo $var; ?>-link" class='tool_show' href="#null" onclick="link('<? echo $var; ?>');">link</a>
						<a id="<? echo $var; ?>-image" class='tool_show' href="#null" onclick="image('<? echo $var; ?>');">image</a>
						
						<div id="<?echo $var; ?>-imagecontainer" class='imagecontainer hidden' style="background-color: #999;">
							<span style="color: white;">insert an image...</span>
							<div id="<? echo $var; ?>-imagebox" class='imagebox'>
								<?
									for($i = 0; $i < $num_medias; $i++) {
										if ($medias[$i]["type"] != "pdf" && $medias[$i]["type"] != "mp4" && $medias[$i]["type"] != "mp3") {
											echo '<div class="image-container" id="'. m_pad($medias[$i]['id']) .'-'. $var .'"><img src="'. $medias[$i]['display'] .'"></div>';
											echo '<script>
											document.getElementById("'. m_pad($medias[$i]['id']) .'-'. $var .'").onclick = (function() {
												// closure for variable issue
												return function() {
													document.getElementById("'. $var .'-imagecontainer").classList.add("hidden");
													document.getElementById("'. $var .'-editable").focus();
													var thisImg = this.childNodes[0];
													addTag("'. $var .'", "div", "img_ctner",thisImg);
												}
											})();
											</script>';
										}
									}
								?>
								</div>
						</div>
					</div>

												<div name='<? echo $var; ?>' class='large editable' contenteditable='true' id='<? echo $var; ?>-editable' onclick="showToolBar('<? echo $var; ?>'); resetViews('<? echo $var; ?>');" style="display: block;"><?
                            if($item[$var])
                                echo $item[$var];
                            ?></div>

                        <textarea name='<? echo $var; ?>' class='large hidden' id='<? echo $var; ?>-textarea' onclick="" onblur=""><?
                            if($item[$var])
                                echo $item[$var];
                        ?></textarea>

						<script>
							addListeners('<?echo $var; ?>');
							if('<?echo $var; ?>' == "body"){
								addListeners_selection('<?echo $var; ?>');
							}
						</script>
						<?

                        // ** end minimal wysiwig toolbar **

						}elseif($var_info["input-type"][$var] == "triggerEditor")
						{

                        // ** start experimental minimal wysiwig toolbar **

                        ?>
					<div id="<?echo $var;?>-toolbar" class="toolbar">
						<a id="<? echo $var; ?>-html" class='right tool_show' href="#null" onclick="sethtml('<? echo $var; ?>');">html</a>
						<a id="<? echo $var; ?>-txt" class='right tool_hide' href="#null" onclick="showrich('<? echo $var; ?>');">done.</a>
						<a id="<? echo $var; ?>-back" class='tool_show' href="#null" onclick="undo('<? echo $var; ?>');">Undo &#8617;</a>
						<a id="<? echo $var; ?>-forward" class='tool_show' href="#null" onclick="redo('<? echo $var; ?>');">&#8618; Redo</a>
						<a id="<? echo $var; ?>-link" class='tool_show' href="#null" onclick="link('<? echo $var; ?>');">link</a>
						<? if($var != 'upcoming_text'){ ?>
						<a id="<? echo $var; ?>-image" class='tool_show' href="#null" onclick="image('<? echo $var; ?>');">image</a>
						<?}?>
						<? if($var == 'body'){ ?>
						<a id="<? echo $var; ?>-subtitle" class='tool_show' href="#null" onclick="addTag('<? echo $var; ?>','h4', 'subtitle');">subtitle</a>
						<?}elseif($var == 'qanda'){?>
						<a id="<? echo $var; ?>-qandaname" class='tool_show' href="#null" onclick="addTag('<? echo $var; ?>','h4', 'qandaname');">Q & A name</a>
						<?}?>
						<div id="<?echo $var; ?>-imagecontainer" class='imagecontainer hidden' style="background-color: #999;">
							<span style="color: white;">insert an image...</span>
							<div id="<? echo $var; ?>-imagebox" class='imagebox'>
								<?
									for($i = 0; $i < $num_medias; $i++) {
										if ($medias[$i]["type"] != "pdf" && $medias[$i]["type"] != "mp4" && $medias[$i]["type"] != "mp3") {
											$thisUrl = $medias[$i]['display'];
											if(isset($medias[$i]['caption'])){
												$thisCaption = $medias[$i]['caption'];
											}else{
												$thisCaption = "";
											}
											
											$addTag = "addTag('" .$var. "', 'img', 'img_ctner_temp', '".$thisUrl."', '".$thisCaption."')";
											echo '<div class="image-container" id="'. m_pad($medias[$i]['id']) .'-'. $var .'" onclick = "'.$addTag.'"><img src="'. $medias[$i]['display'] .'"></div>';
										}
									}
								?>
								</div>
						</div>
					</div>

						<div name='<? echo $var; ?>' class='large editable' contenteditable='true' id='<? echo $var; ?>-editable' onclick="showToolBar('<? echo $var; ?>'); resetViews('<? echo $var; ?>');" style="display: block;"><?
                            if($item[$var])
                                echo $item[$var];
                        ?></div>

                        <textarea name='<? echo $var; ?>' class='large hidden' id='<? echo $var; ?>-textarea' onclick="" onblur=""><?
                            if($item[$var])
                                echo $item[$var];
                        ?></textarea>

						<script>
							addListeners('<?echo $var; ?>');
							// for triggerEditor
							unWrappingTemp('<?echo $var; ?>');
							addListeners_selection('<?echo $var; ?>');
							addListeners_paste('<?echo $var; ?>');

						</script>
						<?

                        // ** end minimal wysiwig toolbar **

						}elseif($var_info["input-type"][$var] == "referencelist")
						{?>
							<a class = "btn_addListItem" href = "#null" onclick = "addListItem('<? echo $var ;?>')">add item</a>
							<?
							$temp = htmlspecialchars($item[$var]);
							$pattern = [htmlspecialchars('<a class = "reference_link" href = '), htmlspecialchars('</a>'), htmlspecialchars('"')];
							$replacement = ["", "",""];
							$temp = str_replace($pattern,$replacement,$temp);
							$temp = explode(htmlspecialchars("<br>"), $temp);
							foreach($temp as &$tp)
								$tp = explode(htmlspecialchars(">"), $tp);
							if(count($temp) > 1){
								$loop_length = count($temp);
							}else{
								$loop_length = 1;
							}
							for($i = 0; $i < $loop_length; $i++){
						?><div class = 'list_name'><? echo $var . "-" . ($i+1); ?></div><input 
							name='<? echo $var."[]"; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
							value='<? echo (isset( $temp[$i][1] ) ? $temp[$i][1] : "(title)" )?>' 
						><input 
							name='<? echo $var."Url[]"; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
							value='<? echo (isset( $temp[$i][0] ) && $temp[$i][0] != "" ? $temp[$i][0] : "(url)" )?>' 
						><?	
							}
						}
						elseif($var == "url")
						{
						?><input name='<? echo $var; ?>'
								type='<? echo $var_info["input-type"][$var]; ?>'
								value='<? echo urldecode($item[$var]); ?>'
								onclick="hideToolBars(); resetViews();"
						><?
						}
						elseif($var_info["input-type"][$var] != "none")
						{
						?><input name='<? echo $var; ?>'
								type='<? echo $var_info["input-type"][$var]; ?>'
								value='<? echo htmlspecialchars($item[$var], ENT_QUOTES); ?>'
								onclick="hideToolBars(); resetViews();"
						><?
						}
					?></div>
				</div><?
				}
				// show existing images
				for($i = 0; $i < $num_medias; $i++)
				{
					$im = str_pad($i+1, 2, "0", STR_PAD_LEFT);
				?><div class="existing-image">
					<div class="field-name">Image <? echo $im; ?></div>
					<div class='preview'>
						<a href="<? echo $medias[$i]['file']; ?>" target="_blank">
							<img src="<? echo $medias[$i]['display']; ?>">
						</a>
					</div>
					<textarea name="captions[]"><?echo $medias[$i]["caption"];?></textarea>
					<span>rank</span>
					<select name="ranks[<? echo $i; ?>]"><?
						for($j = 1; $j <= $num_medias; $j++)
						{
							if($j == $medias[$i]["rank"])
							{
							?><option selected value="<? echo $j; ?>"><?
								echo $j;
							?></option><?php
							}
							else
							{
							?><option value="<? echo $j; ?>"><?
								echo $j;
							?></option><?php
							}
						}
					?></select>
					<label>

						<input
							type="radio"
							name="thumbnail"
							value= "<? echo $medias[$i]["display"]; ?>"
							<? 
							if(!isset($item["thumbnail"]) && $i == 0){ ?>
								checked
							<? }else if( $medias[$i]["display"] == $item["thumbnail"]){ ?>
								checked
							<? } ?>
						>
					thumbnail</label>
					<label>
						<input
							type="checkbox"
							name="deletes[<? echo $i; ?>]"
						>
					delete image</label>
					<input
						type="hidden"
						name="medias[<? echo $i; ?>]"
						value="<? echo $medias[$i]['id']; ?>"
					>
					<input
						type="hidden"
						name="types[<? echo $i; ?>]"
						value="<? echo $medias[$i]['type']; ?>"
					>
				</div><?php
				}
				// upload new images
				for($j = 0; $j < $max_uploads; $j++)
				{
					$im = str_pad(++$i, 2, "0", STR_PAD_LEFT);
				?><div class="image-upload">
					<span class="field-name">Image <? echo $im; ?></span>
					<span>
						<input type="file" name="uploads[]">
					</span>
					<!--textarea name="captions[]"><?php
							echo $medias[$i]["caption"];
					?></textarea-->
				</div><?php
				} ?>
				<div class="button-container">
					<input
						type='hidden'
						name='action'
						value='update'
					>
					<input
						type='button'
						name='cancel'
						value='Cancel'
						onClick="<? echo $js_back; ?>"
					>
					<input
						type='submit'
						name='submit'
						value='Update Object'
						onclick='commitAll();'
					>
				</div>
			</div>
		</form>
	</div>
<?php
}
// THIS CODE NEEDS TO BE FACTORED OUT SO HARD
// basically the same as what is happening in add.php
else
{
	$new = array();
	// objects
	foreach($vars as $var)
	{	
		if($var_info["input-type"][$var] == "referencelist"){
			$temp = "";
			$thisUrl = $var."Url";

			foreach($rr->$var as $key => $rl){
				if(!empty($rl) && $rl != "(title)"){
					$temp .= '<a class = "reference_link" href = "'.$_POST[$thisUrl][$key].'">'.$rl.'</a><br>';
				}
			}
			$rr->$var = $temp;
		}elseif($var == "thumbnail"){
			$rr->$var = $_POST['thumbnail'];
		}
		$new[$var] = addslashes($rr->$var);
		$item[$var] = addslashes($item[$var]);
	}

	$siblings = $oo->siblings($uu->id);
	$updated = update_object($item, $new, $siblings, $vars);

	// process new media
	$updated = (process_media($uu->id) || $updated);

	// delete media
	// check to see if $rr->deletes exists (isset)
	// because if checkbox is unchecked that variable "doesn't exist"
	// although the expected behaviour is for it to exist but be null.

	if(isset($rr->deletes))
	{
		foreach($rr->deletes as $key => $value)
		{
			$m = $rr->medias[$key];
			$mm->deactivate($m);
			$updated = true;
		}
	}

	// update caption, weight, rank
	$num_captions = sizeof($rr->captions);
	if (sizeof($rr->medias) < $num_captions)
		$num_captions = sizeof($rr->medias);

	for ($i = 0; $i < $num_captions; $i++)
	{
		unset($m_arr);
		$m_id = $rr->medias[$i];
		$caption = addslashes($rr->captions[$i]);
		$rank = addslashes($rr->ranks[$i]);
		$thumbnail = addslashes($rr->thumbnail);

		$m = $mm->get($m_id);
		if($m["caption"] != $caption)
			$m_arr["caption"] = "'".$caption."'";
		if($m["rank"] != $rank)
			$m_arr["rank"] = "'".$rank."'";

		// if($m["thumbnail"] != $thumbnail)
		// 	$m_arr["thumbnail"] = "'".$thumbnail."'";

		if($m_arr)
		{
			$arr["modified"] = "'".date("Y-m-d H:i:s")."'";
			$updated = $mm->update($m_id, $m_arr);
		}
	}
	?><div class="self-container"><?
		// should change this url to reflect updated url
		$urls = array_slice($uu->urls, 0, count($uu->urls)-1);
		$u = implode("/", $urls);
		$url = $admin_path."browse/";
		if(!empty($u))
			$url.= $u."/";
		$url.= $new['url'];
		?><p><a href="<? echo $url; ?>"><?php echo $new['name1']; ?></a></p><?
	// Job well done?
	if($updated)
	{
	?><p>Record successfully updated.</p><?
	}
	else
	{
	?><p>Nothing was edited, therefore update not required.</p><?
	}
	?></div><?
}
?></div>
</div>
