<script type = "text/javascript" src = '<? echo $admin_path;?>static/wysiwyg_func.js'></script>
<?
$browse_url = $admin_path.'browse/'.$uu->urls();

$vars = array("cato", "name1", "event_date", "event_time", "location", "upcoming_text", "website", "exhibit", "reading", "body", "url", "rank", "qanda", "begin", "end" );

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
$var_info["input-type"]["upcoming_text"] = "textarea";
$var_info["input-type"]["website"] = "referencelist";
$var_info["input-type"]["exhibit"] = "referencelist";
$var_info["input-type"]["reading"] = "referencelist";

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

// for use on add.php
// return false if process fails
// (siblings must not have same url slug as object)
// return id of new object on success
function insert_object(&$new, $siblings)
{
	global $oo;
	
	// set default name if no name given
	if(!$new['name1'])
		$new['name1'] = 'untitled';

	// slug-ify url
	if($new['url'])
		$new['url'] = slug($new['url']);
	
	if(empty($new['url']))
		$new['url'] = slug($new['name1']);
	
	// make sure url doesn't clash with urls of siblings
	$s_urls = array();
	foreach($siblings as $s_id)
		$s_urls[] = $oo->get($s_id)['url'];

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
	
	// make mysql happy with nulls and such	
	foreach($new as $key => $value)
	{
		if($value)
			$new[$key] = "'".$value."'";
		else
			$new[$key] = "null";
	}
	$id = $oo->insert($new);
	
	// need to strip out the quotes that were added to appease sql
	$u = str_replace("'", "", $new['url']);
	$url = valid_url($u, strval($id), $s_urls);
	if($url != $u)
	{
		$new['url'] = "'".$url."'";
		$oo->update($id, $new);
	}
	
	return $id;
}

?><div id="body-container">
	<div id="body" class="centre"><?
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
	// END TODO
	
		// this code is duplicated in:
		// + link.php
		// + add.php
		?><div class="self-container">
			<div class="self">
				<a href="<? echo $browse_url; ?>"><? echo $name; ?></a>
			</div>
		</div><?
	
		
		// show form
		if($rr->action != "add") 
		{
			$form_url = $admin_path."add";
			if($uu->urls())
				$form_url.="/".$uu->urls();
		?><div id="form-container">
			<div class="self">You are adding a new object.</div>
			<form 
				enctype="multipart/form-data" 
				action="<? echo $form_url; ?>" 
				method="post"
			>
				<div class="form"><script>

				function link(name) {
						var linkURL = prompt('Enter a URL:', 'http://');
						if (linkURL === null || linkURL === "") {
							return;
						}

						document.execCommand('createlink', false, linkURL);
				}

				function addListeners(name) {
					document.getElementById(name + '-html').addEventListener('click', function(e) {resignImageContainer(name);}, false);
					// document.getElementById(name + '-bold').addEventListener('click', function(e) {resignImageContainer(name);}, false);
					// document.getElementById(name + '-italic').addEventListener('click', function(e) {resignImageContainer(name);}, false);
					document.getElementById(name + '-link').addEventListener('click', function(e) {resignImageContainer(name);}, false);
				}

				function resignImageContainer(name) {
					var imagecontainer = document.getElementById(name + '-imagecontainer');
					if (imagecontainer.style.display === 'block') {
						imagecontainer.style.display = 'none';
					}
				}
				function image(name) {
					var imagecontainer = document.getElementById(name + '-imagecontainer');
					var imagebox = document.getElementById(name + '-imagebox');
					// toggle image box
					if (imagecontainer.style.display !== 'block') {
						imagecontainer.style.display = 'block';
					} else {
						imagecontainer.style.display = 'none';
					}
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
				// object data
				foreach($vars as $var)
				{
					?><div class="field">
						<div class="field-name"><? echo $var_info["label"][$var]; ?></div>
						<div id = "<? echo $var; ?>-body" class = "field-body"><?
						if($var_info["input-type"][$var] == "textarea")
						{
						?>
						<div id="<?echo $var;?>-toolbar" class="toolbar">
						<a id="<? echo $var; ?>-html" class='right tool_show' href="#null" onclick="sethtml('<? echo $var; ?>');">html</a>
						<a id="<? echo $var; ?>-txt" class='right tool_hide' href="#null" onclick="showrich('<? echo $var; ?>');">done.</a>
						<a id="<? echo $var; ?>-back" class='tool_show' href="#null" onclick="undo('body');">Undo &#8617;</a>
						<a id="<? echo $var; ?>-forward" class='tool_show' href="#null" onclick="redo('body');">&#8618; Redo</a>
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
													document.getElementById("'. $var .'-imagecontainer").style.display = "none";
													document.getElementById("'. $var .'-editable").focus();
													document.execCommand("insertImage", 0, "'. $medias[$i]['display'] .'");
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
						}elseif($var_info["input-type"][$var] == "triggerEditor")
						{

                        // ** start experimental minimal wysiwig toolbar **

                        ?>

					<div id="<?echo $var;?>-toolbar" class="toolbar">
						<a id="<? echo $var; ?>-html" class='right tool_show' href="#null" onclick="sethtml('<? echo $var; ?>');">html</a>
						<a id="<? echo $var; ?>-txt" class='right tool_hide' href="#null" onclick="showrich('<? echo $var; ?>');">done.</a>
						<a id="<? echo $var; ?>-back" class='tool_show' href="#null" onclick="undo('body');">Undo &#8617;</a>
						<a id="<? echo $var; ?>-forward" class='tool_show' href="#null" onclick="redo('body');">&#8618; Redo</a>
						<a id="<? echo $var; ?>-link" class='tool_show' href="#null" onclick="link('<? echo $var; ?>');">link</a>
						<a id="<? echo $var; ?>-image" class='tool_show' href="#null" onclick="image('<? echo $var; ?>');">image</a>
						<a id="<? echo $var; ?>-subtitle" class='tool_show' href="#null" onclick="addTag('<? echo $var; ?>','h4', 'subtitle');">subtitle</a>
						
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
													document.getElementById("'. $var .'-imagecontainer").style.display = "none";
													document.getElementById("'. $var .'-editable").focus();
													document.execCommand("insertImage", 0, "'. $medias[$i]['display'] .'");
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
							// for triggerEditor

							addListeners_selection('<?echo $var; ?>');
							addListeners_paste('<?echo $var; ?>');
							addListeners_input('<?echo $var; ?>');

						</script>
						<?
						}elseif($var_info["input-type"][$var] == "referencelist")
						{?>
						<a class = "btn_addListItem" href = "#null" onclick = "addListItem('<? echo $var ;?>')">add item</a>
						<div class = 'list_name'><? echo $var . "-1"; ?></div>
						<input 
							name='<? echo $var."[]"; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
							value = "(title)"
						><input 
							name='<? echo $var."Url[]"; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
							value = "(url)"
						><?	
						}
						else
						{
						?><input 
							name='<? echo $var; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
						><?
						}
						?></div>
					</div><?
				}
				//  upload new images
				for ($j = 0; $j < $max_uploads; $j++)
				{
					?><div class="field">
						<span class="field-name">Image <? echo $j+1; ?></span>
						<span>
							<input type='file' name='uploads[]'>
							<!-- textarea name="captions[]" class="caption"></textarea -->
						</span>
					</div><?
				}
				?></div>
				<div class="button-container">
					<input
						type='hidden'
						name='action'
						value='add'
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
						value='Add Object'
					>
				</div>
			</form>
		</div><?
		}
		// process form
		else
		{
			$f = array();
			// objects
			foreach($vars as $var){
				if($var_info["input-type"][$var] == "referencelist"){
					
					$temp = "";
					$thisUrl = $var."Url";
					foreach($rr->$var as $key => $rl){
						if(!empty($rl) && $rl != "(title)"){
							$temp .= '<a class = "reference_link" href = "'.$_POST[$thisUrl][$key].'">'.$rl.'</a><br>';
						}
					}
					
					$rr->$var = $temp;
					
				}
				$f[$var] = addslashes($rr->$var);

				
			}

			$siblings = $oo->children_ids($uu->id);
			$toid = insert_object($f, $siblings);

			if($toid)
			{
				// wires
				$ww->create_wire($uu->id, $toid);
				// media
				process_media($toid);
			?><div>Record added successfully.</div><?
			}
			else
			{
			?><div>Record not created, please <a href="<? echo $js_back; ?>">try again.</a></div><?
			}
		} 
	?></div>
</div>