<script type = "text/javascript" src = '<? echo $admin_path;?>static/wysiwyg_func.js'></script>
<?

require_once($include_path.'function_strToItems.php');
require_once($include_path.'function_itemsToStr.php');

$browse_url = $admin_path.'browse/'.$uu->urls();
$isEdit = true;
$vars = array("cato", "name1", "event_date", "event_time", "location", "upcoming_text", "website", "exhibit", "reading", "body", "url", "rank", "qanda", "begin", "end","thumbnail","reading_toid","reading_fromid"  );

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
$var_info["input-type"]["location"] = "select";
$var_info["input-type"]["cato"] = "text";
$var_info["input-type"]["upcoming_text"] = "triggerEditor";
$var_info["input-type"]["website"] = "referencelist";
$var_info["input-type"]["exhibit"] = "referencelist";
$var_info["input-type"]["reading"] = "referencelist";
$var_info["input-type"]["thumbnail"] = "none";
$var_info["input-type"]["reading_toid"] = "hidden";
$var_info["input-type"]["reading_fromid"] = "hidden";

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

$location_url = "json/location.json";
$location = file_get_contents($location_url);
$location = json_decode($location, true);
$reading_keep = array();
$id_resource = $oo->urls_to_ids(array("resource"))[0];

$hasReading = false;

if(isset($item['reading_toid'])){
	$hasReading = true;
	$old_reading = array();
	$old_reading_id = explode(',', str_replace(' ', '', $item['reading_toid']));
	foreach($old_reading_id as $ori)
		$old_reading[] = $oo->get($ori);
	// $item['reading_toid'] = $old_reading_id;
}

// return false if object not updated,
// else, return true
function update_object(&$old, &$new, $siblings, $vars, &$old_reading)
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
	if(!empty($new['reading']))
	{	
		$hasNewReading = true;
		// forming $new_reading
		global $old_reading_id;
		global $old_reading;
		global $reading_keep;
		global $thisId;
		global $id_resource;
		global $hasReading;
		global $ww;
		$new_reading = array(); // to carry all the blocks in this update
		$arr_reading = array(); // to carry those which need to be updated

		foreach($reading_keep as $key => $rk){
			$new_reading[$key]['name1'] = $rk[0];
			$new_reading[$key]['reading'] = '<a class = "reference_link" href = "'.$rk[1].'">'.$rk[0].'</a><br>';
			$new_reading[$key]['url'] = slug($new_reading[$key]['name1']);
			$new_reading[$key]['reading_fromid'] = $thisId;
			$new_reading[$key]['event_date'] = $new['event_date'];

		}

		if($hasReading){
			// already had reading;
			$new['reading_toid'] = explode(',', str_replace(' ', ' ', $new['reading_toid']));
			$loop_length = count($new_reading);
			$toInsert_index = array(); // for new readings added in this update
			
			if( count($old_reading) >= $loop_length){
				$hasNewReading = false;
				$loop_length = count($old_reading);
			}
			// starting fileter out unhooked and to-be-ininserted.
			// looping through each reading
			for($i = 0 ; $i< $loop_length; $i++ ){
				if( $old_reading[$i] != $new_reading[$i] ){
					// update of item detected, now needs to update
					if( $i < count($old_reading)){
						// if just updating
						$arr_reading[$i] = $new_reading[$i] ?  $new_reading[$i] : "null";
						if($arr_reading[$i] == "null"){
							//  a reading got deleted/unhooked
							$this_reading_fromid = $oo->get($id_reading[$i])['reading_fromid'];
							$this_reading_fromid = explode(',', str_replace(' ', ' ', $this_reading_fromid));
							if(count($this_reading_fromid) == 1){
								// if this is the only event related to this reading
								$oo->deactivate($id_reading[$i]);
							}
							else{
								// else remove this event id from the reading
								$key = array_search($thisId, $this_reading_fromid);
								unset( $this_reading_fromid[$key] );
								$new_reading[$i]['reading_fromid'] = implode(',',$this_reading_fromid);
							}
							unset($new['reading_toid'][$i]);
							unset($arr_reading[$i]);
						}else{
							
							foreach($arr_reading[$i] as $j => &$ar){
								$ar = $ar ?  "'".$new_reading[$i][$j]."'" : "null";
							}
						}
					}else{
						// adding new reading
						$arr_reading[$i] = $new_reading[$i] ?  $new_reading[$i] : "null";
						foreach($arr_reading[$i] as $j => &$ar){
							$ar = $ar ?  "'".$new_reading[$i][$j]."'" : "null";
						}
						$toInsert_index[] = $i;
					}
					
				}
			}
			foreach($arr_reading as $i =>$ar){
				if($ar!='null'){
					$siblings_reading = $oo->children_ids($id_resource);
					$s_urls_reading = array();
					foreach($siblings_reading as $s_id_r)
						$s_urls_reading[] = $oo->get($s_id_r)['url'];
		 			$u_reading = str_replace("'", "", $ar['url']);
		 			$url_reading = valid_url($u_reading, strval($id_reading[$i]), $s_urls_reading);
					if($url_reading != $u_reading)
					{
						$ar['url'] = "'".$url_reading."'";
						if( array_search($i, $toInsert_index) !==false ){
							$new['reading_toid'][] = $oo->insert($ar);
							$ww->create_wire($id_resource, end($new['reading_toid']));
						}else{
							$oo->update($id_reading[$i], $ar);
						}
						
						
					}else{
						if( array_search($i, $toInsert_index) !==false ){
							$new['reading_toid'][] = $oo->insert($ar);
							$ww->create_wire($id_resource, end($new['reading_toid']));
						}else{
							$oo->update($siblings_reading[$i], $ar);
						}
						// update the original reading;
						
					}
				}
			}
			$new['reading_toid'] = implode(',',$new['reading_toid']);


		}else{
			// didn't have reading;
			for($i = 0; $i < count($new_reading) ; $i++){
				$siblings_reading = $oo->children_ids($id_resource);
				$s_urls_reading = array();
				foreach($siblings_reading as $s_id_r)
					$s_urls_reading[] = $oo->get($s_id_r)['url'];

		 		foreach ($new_reading[$i] as $key => $value) {
		 			if($value)
						$new_reading[$i][$key] = "'".$value."'";
					else
						$new_reading[$i][$key] = "null";
				}
				$id_reading[] = $oo->insert($new_reading[$i]);
				$u_reading = str_replace("'", "", $new_reading[$i]['url']);
				$url_reading = valid_url($u_reading, strval($id_reading[$i]), $s_urls_reading);
				if($url_reading != $u_reading)
				{
					$new_reading[$i]['url'] = "'".$url_reading."'";
					$oo->update(end($id_reading), $new_reading[$i]);
				}
			}
			$new['reading_toid'] = implode(',',$id_reading);
		}

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
					imagecontainer.classList.add('hidden');
				}
				function image(name) {
					console.log("image()");
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
					}

				function hideToolBars() {
					}
				function commitAll() {
					var names = <?
						$textnames = [];
						foreach($vars as $var) {
							if($var_info["input-type"][$var] == "triggerEditor" ) {
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
					// If the editor is activated
					if(editable){
						if (!editable.classList.contains('hidden')) {
							var html = editable.innerHTML;
							textarea.value = html;    // update textarea for form submit
						} else {
							var html = textarea.value;
							editable.innerHTML = html;    // update editable
						}
					}else{
						var temp = document.createElement("div");
						temp.innerText = textarea.value;
						var str = ''+temp.innerHTML;
						str = str.replace(/(?:\r\n|\r|\n)/g, '<br>');
						str = str.replace(/<br><br>/g , '<\/div><div>');
						str = str.replace('<br>', '</div><div>');
						str = '<div>'+str+'</div>';
						textarea.value = str;
					}
				}
				function format(name){
					var editable = document.getElementById(name + '-editable');
					var textarea = document.getElementById(name + '-textarea');
					var temp = document.createElement("div");

					if (!editable.classList.contains('hidden'))
						temp.innerHTML = editable.innerHTML;
					else
						temp.innerText = text.value;

					var str = ''+temp.innerHTML;
					str = str.replace(/(?:\r\n|\r|\n)/g, '<br>');
					str = str.replace(/<br><br>/g , '<\/div><div>');
					str = str.replace('<br>', '</div><div>');
					str = '<div>'+str+'</div>';
					editable.innerHTML = str;
					textarea.value = str;
				}

				function resetViews(name) {
					var names = <?
						$textnames = [];
						foreach($vars as $var) {
							if($var_info["input-type"][$var] == "triggerEditor" && $item[$var]) {
								$textnames[] = $var;
							}
						}
						echo '["' . implode('", "', $textnames) . '"]'
						?>;

					for (var i = 0; i < names.length; i++) {
						if (!(name && name === names[i]))
							showrich(names[i]);
					}
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

				function toggleSelectList(name){
					var thisList = document.getElementById(name+"-selectList");
					thisList.classList.toggle('showingSelectList');
					if(thisList.classList.contains('showingSelectList')){
						thisList.children[0].innerText = "hide list [-]";
					}else{
						thisList.children[0].innerText = "show list [+]";
					}
				}
				
				</script>
				<?php
				// show object data
				$thisId = $oo->urls_to_ids(array($item['url']));
				

				// var_dump($thisId);
				// die();
				?>
				<br><div id = "id_display">ID: <? echo $thisId[0]; ?></div>
				
				<? 
				if(isset($item['reading_fromid'])){
					?><div id = "hooked_display">This reading is hooked with the event(s):<br><?
					$thisHookedEvents_id = explode(',', str_replace(' ','',$item['reading_fromid']));
					$thisHookedEvents = array();
					foreach($thisHookedEvents_id as $thei){
						$thisHookedEvents[] = $oo->name($thei);
					}
					foreach($thisHookedEvents as $key => $name)
						echo $name.' (ID = '.$thisHookedEvents_id[$key].')<br>';
					?></div><?
				}elseif(isset($item['reading_toid'])){
					?><div id = "hooked_display">This event is hooked with the reading(s):<br><?
					$thisHookedReadings_id = explode(',', str_replace(' ','',$item['reading_toid']));
					$thisHookedReadings = array();
					foreach($thisHookedReadings_id as $thei){
						$thisHookedReadings[] = $oo->name($thei);
					}
					foreach($thisHookedReadings as $key => $name)
						echo $name.' (ID = '.$thisHookedReadings_id[$key].')<br>';
					?></div><?
				}
				
				foreach($vars as $var)
				{
				?><div class="field">
					<div class="field-name"><? echo $var_info["label"][$var]; ?></div>
					<div id = "<? echo $var; ?>-body" class = "field-body"><?
						if($var_info["input-type"][$var] == "triggerEditor")
						{

						require('views/triggerEditor.php');

						}elseif($var_info["input-type"][$var] == "referencelist")
						{?>
							<a class = "btn_addListItem" href = "#null" onclick = "addListItem('<? echo $var ;?>')">add item</a>
							<?
							$temp = strToItems($item[$var]);

							if(count($temp) > 1){
								$loop_length = count($temp);
							}else{
								$loop_length = 1;
							}
							for($i = 0; $i < $loop_length; $i++){
						?><div class = 'list_name'><? echo $var . "-" . ($i+1); ?></div><input 
							name='<? echo $var."[".$i."][]"; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
							value='<? echo (isset( $temp[$i][1] ) ? $temp[$i][1] : "(title)" )?>' 
						><input 
							name='<? echo $var."[".$i."][]"; ?>' 
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
								onclick=""
						><?
						}
						elseif($var == "location")
						{
						?>
						<div id = '<? echo $var; ?>-selectList' class = "selectList">
							<a class = "selectList_btn" href = "#null" onclick = "toggleSelectList('<? echo $var; ?>')">show list [+]</a>
							<div class = "selectList_list shadowBox">
								*** you can edit this list at json/location.json ***
							<? 
							foreach($location as $list => $adds){
								?>
								<ul>
									<? echo $list; ?>
									<?
									foreach($adds as $add){
										?>
										<li><? echo $add["loc"].'<br> --- '.$add["address"]; ?></li>
										<?
									}
									echo '<br>'; ?>
								</ul>

								<?
							}
							?>
								
							</div>
						</div>
						<select name ='<? echo $var; ?>' type='<? echo $var_info["input-type"][$var]; ?>' > 
							<?
							foreach($location as $list => $adds){
								?>
								<option class = '<? echo $var; ?>-option' <? 
									if ($list == htmlspecialchars($item[$var], ENT_QUOTES)) {
										?>
										selected = "selected" 
										<?
									}
								?>value = '<? echo $list; ?>'><? echo $list; ?></option>

								<?
							}
							?>
						</select>
						<?	
						}
						elseif($var_info["input-type"][$var] == 'hidden'){
						?><input name='<? echo $var; ?>'
							type='<? echo $var_info["input-type"][$var]; ?>'
							value='<? echo htmlspecialchars($item[$var], ENT_QUOTES); ?>'
							onclick=""
						>
						<?	
						}
						elseif($var_info["input-type"][$var] != "none")
						{
						?><input name='<? echo $var; ?>'
								type='<? echo $var_info["input-type"][$var]; ?>'
								value='<? echo htmlspecialchars($item[$var], ENT_QUOTES); ?>'
								onclick=""
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
			while(end($rr->$var) == '(title)'){
				array_pop($rr->$var);
			}
			if($var == 'reading'){
				$reading_keep = $rr->$var;
			}
			$rr->$var = itemsToStr( $rr->$var, 'reference_link', $var);
		}elseif($var == "thumbnail"){
			$rr->$var = $_POST['thumbnail'];
		}elseif($var == "reading_fromid" || $var == "reading_toid" ){
			$rr->$var = $item[$var];
		}

		$new[$var] = addslashes($rr->$var);
		$item[$var] = addslashes($item[$var]);
	}

	$siblings = $oo->siblings($uu->id);
	$updated = update_object($item, $new, $siblings, $vars, $old_reading);

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
