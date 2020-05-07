<script type = "text/javascript" src = '<? echo $admin_path;?>static/wysiwyg_func.js'></script>
<?

require_once($include_path.'function_strToItems.php');
require_once($include_path.'function_itemsToStr.php');

$browse_url = $admin_path.'browse/'.$uu->urls();
$isAdd = true;
$vars = array("cato", "name1", "event_date", "event_time", "location", "main_one", "website", "exhibit", "reading", "main_two", "url", "rank", "qanda", "begin", "end","thumbnail","reading_toid","reading_fromid"  );

$var_info = array();

$var_info["input-type"] = array();
$var_info["input-type"]["cato"] = "text";
$var_info["input-type"]["name1"] = "text";
$var_info["input-type"]["event_date"] = "text";
$var_info["input-type"]["event_time"] = "text";
$var_info["input-type"]["location"] = "triggerEditor";
$var_info["input-type"]["main_one"] = "triggerEditor";
$var_info["input-type"]["website"] = "referencelist";
$var_info["input-type"]["exhibit"] = "referencelist";
$var_info["input-type"]["reading"] = "referencelist";
$var_info["input-type"]["main_two"] = "triggerEditor";
$var_info["input-type"]["qanda"] = "triggerEditor";
$var_info["input-type"]["begin"] = "text";
$var_info["input-type"]["end"] = "text";
$var_info["input-type"]["url"] = "text";
$var_info["input-type"]["rank"] = "text";
$var_info["input-type"]["thumbnail"] = "none";
$var_info["input-type"]["reading_toid"] = "hidden";
$var_info["input-type"]["reading_fromid"] = "hidden";

$var_info["label"] = array();
$var_info["label"]["cato"] = "Event Category";
$var_info["label"]["name1"] = "Name";
$var_info["label"]["event_date"] = "Date (YYYY-MM-DD)";
$var_info["label"]["event_time"] = "Time (24 hours) (hh-mm)";
$var_info["label"]["location"] = "Location";
$var_info["label"]["main_one"] = "Main Text / Upcoming Text";
$var_info["label"]["website"] = "Website";
$var_info["label"]["exhibit"] = "Exhibition";
$var_info["label"]["reading"] = "Reading List";
$var_info["label"]["main_two"] = "Main Text 2 / Archive Text";
$var_info["label"]["qanda"] = "Q & A";
$var_info["label"]["url"] = "URL Slug";
$var_info["label"]["rank"] = "Rank";
$var_info["label"]["begin"] = "Begin";
$var_info["label"]["end"] = "End";

$reading_keep = array();

// for use on add.php
// return false if process fails
// (siblings must not have same url slug as object)
// return id of new object on success
function insert_object(&$new, $siblings)
{
	global $oo;
	$id_resource = $oo->urls_to_ids(array("resource"))[0];
	
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

	if(!empty($new['reading']) && !empty($new['cato'])){
		$id_reading = array();
		$new_reading = array();
		global $reading_keep;
		foreach($reading_keep as $key => $rk){
			$new_reading[$key]['name1'] = $rk[0];
			$new_reading[$key]['reading'] = '<a class = "reference_link" href = "'.$rk[1].'">'.$rk[0].'</a><br>';
			$new_reading[$key]['url'] = slug($new_reading[$key]['name1']);
			$new_reading[$key]['reading_fromid'] = $oo->id;
			$new_reading[$key]['event_date'] = $new['event_date'];
		}
		

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
		
		
		$new['reading_toid'] = implode(', ', $id_reading);
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
	if(!empty($new['reading']) && $id_reading){
		foreach( $id_reading as $ir){
			$oo->update($ir, array('reading_fromid'=>$id));
		}
	}

	

	// need to strip out the quotes that were added to appease sql
	$u = str_replace("'", "", $new['url']);
	$url = valid_url($u, strval($id), $s_urls);
	if($url != $u)
	{
		$new['url'] = "'".$url."'";
		$oo->update($id, $new);
	}
	
	return [$id, $id_reading];
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
		if($rr->action != "add") 
		{
			$form_url = $admin_path."add";
			if($uu->urls())
				$form_url.="/".$uu->urls();
		?><div id="form-container">
			<div class="self">You are adding a new object.</div>
			<form 
				id = 'add_form'
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
					document.getElementById(name + '-bold').addEventListener('click', function(e) {resignImageContainer(name);}, false);
					document.getElementById(name + '-italic').addEventListener('click', function(e) {resignImageContainer(name);}, false);
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
					newElements[1].name = name+"["+(order-1)+"][]";
					newElements[2].name = name+"["+(order-1)+"][]";
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

				function submitForm(e){
					e.preventDefault();
					commitAll();
					var sAdd_form = document.getElementById('add_form');
					console.log(sAdd_form);
					sAdd_form.submit();
					
				}
				
				</script>
				<?php
				// object data
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
						<div class = 'list_name'><? echo $var . "-1"; ?></div>
						<input 
							name='<? echo $var."[0][]"; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
							value = "(title)"
						><input 
							name='<? echo $var."[0][]"; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
							value = "(url)"
						><?	
						}
						elseif($var_info["input-type"][$var] != "none")
						{
						?><input name='<? echo $var; ?>'
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
						onclick = 'submitForm(event);'
						type='submit' 
						name='btnsubmit' 
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
				if($var_info["input-type"][$var] == 'referencelist'){
					if($var == 'reading'){
						$reading_keep = $rr->$var;
					}
					$rr->$var = itemsToStr( $rr->$var, 'reference_link', $var);
				}
				$f[$var] = addslashes($rr->$var);
			}

			$siblings = $oo->children_ids($uu->id);
			$id_array = insert_object($f, $siblings);
			$toid = $id_array[0];
			if(isset($id_array[1]))
				$toid_reading = $id_array[1];
			$fromid_resource = $oo->urls_to_ids(array("resource"))[0];
			if($toid)
			{
				
				if( ($new['reading'] && $toid_reading) || !($new['reading'] && !$toid_reading)){
					// wires
					$ww->create_wire($uu->id, $toid);
					if($toid_reading){
						foreach($toid_reading as $toid_r)
							$ww->create_wire($fromid_resource, $toid_r);
					}
					// media
					process_media($toid);
				?><div>Record added successfully.</div><?
				}elseif(!$toid_reading){
					?><div>New readings not added under Resource. Please try again</div><?
				}
			
			}
			else
			{
			?><div>Record not created, please <a href="<? echo $js_back; ?>">try again.</a></div><?
			}
		} 
	?></div>
</div>