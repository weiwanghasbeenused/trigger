<?

	$eventType = $uri[2];
	$fromid = end($oo->urls_to_ids(array($eventType)));
	$nav_items = array(
		array(
			'name1' => $eventType,
			'url' => '/events-manager/'.$eventType,
			'class' => ''
		)
	);

	// add.php

	$vars = array("name1", "deck", "body", "notes",  "url", "rank", "begin", "end");

	$var_info = array();

	$var_info["input-type"] = array();
	$var_info["input-type"]["name1"] = "text";
	$var_info["input-type"]["deck"] = "textarea";
	$var_info["input-type"]["body"] = "textarea";
	$var_info["input-type"]["notes"] = "textarea";
	$var_info["input-type"]["begin"] = "text";
	$var_info["input-type"]["end"] = "text";
	$var_info["input-type"]["url"] = "text";
	$var_info["input-type"]["rank"] = "text";

	$var_info["label"] = array();
	$var_info["label"]["name1"] = "Name";
	$var_info["label"]["deck"] = "Synopsis";
	$var_info["label"]["body"] = "Detail";
	$var_info["label"]["notes"] = "Notes";
	$var_info["label"]["begin"] = "Begin";
	$var_info["label"]["end"] = "End";
	$var_info["label"]["url"] = "URL Slug";
	$var_info["label"]["rank"] = "Rank";

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

?><section id = 'main'>
	<?
	if($rr->action != "add"){
		$form_url = implode($uri, '/');
	?>
	<script src = '/static/js/events-manager-function.js'></script>
		<form
			enctype="multipart/form-data"
			action="<? echo $form_url; ?>"
			method="POST"
			id = 'add-form'
		>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-tag' class = 'caption-roman'>Event Type</label>
			<input id = 'add-event-tag' name = 'event-tag' type = 'text'>
		</div>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-title' class = 'caption-roman'>Title</label>
			<input id = 'add-event-title' name = 'event-title' type = 'text'>
		</div>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-subtitle' class = 'caption-roman'>Subtitle</label>
			<input id = 'add-event-subtitle' name = 'event-subtitle' type = 'text'>
		</div>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-time' class = 'caption-roman'>Event Time (ex: 2021-01-01 18:00)</label>
			<input id = 'add-event-time' name = 'event-time' type = 'text'>
		</div>
		<div id="location-input-section" class = 'input-section body-roman'>
			<div class = 'wysiwyg-container'>
				<label class = 'caption-roman'>Location</label><br>
				<div class = 'wysiwyg-text-editor wysiwyg-editor'>
					<span class="toolbar dontdisplay">
						<?php if ($user == 'admin'): ?>
							<a id="" class='tool-html right' href="#null" >html</a>
							<a id="" class='tool-txt right dontdisplay' href="#null" >done.</a>
						<?php endif; ?>
		                <a class='tool-link' href="#null" onclick="link(true);">link</a>
					</span>

					<?php if ($user == 'guest'): ?>
						<div name='event-location' class='large editable' contenteditable='false' id='' onclick="" style="">
					<?php else: ?>
						<div name='event-location' class='large editable' contenteditable='true' id='' onclick="" style="">
					<?php endif; ?>
					</div>
					<textarea rows='1' name='event-location' class='large dontdisplay'></textarea>
				</div>
			</div>
		</div>
		<div id = 'input-section-body' class = 'input-section body-roman'>
			<div class = 'body-section wysiwyg-container'>
				<label class = 'section-title-label caption-roman'>Section Title - 1</label>
				<input class = 'section-title-input' name = 'section-title[]' type = 'text'>
				<label class = 'body-text-label caption-roman'>Body Text - 1 </label><br>
				<div class = 'wysiwyg-text-editor wysiwyg-editor'>
					<span class="toolbar dontdisplay">
						<?php if ($user == 'admin'): ?>
							<a id="" class='tool-html right' href="#null" >html</a>
							<a id="" class='tool-txt right dontdisplay' href="#null" >done.</a>
						<?php endif; ?>
						<a class='tool-bold' href="#null" onclick="document.execCommand('bold',false,null);">bold</a>
		                <a class='tool-italic' href="#null" onclick="document.execCommand('italic',false,null);">italic</a> 
		                <a class='tool-indent' href="#null" onclick="indent();">indent</a>
		                <a class='tool-reset' href="#null" onclick="reset();">&nbsp;&times;&nbsp;</a>
		                &nbsp;
		                <a class='tool-link' href="#null" onclick="link();">link</a>
					</span>

				<?php if ($user == 'guest'): ?>
					<div name='body[]' class='large editable' contenteditable='false'>
				<?php else: ?>
					<div name='body[]' class='large editable' contenteditable='true'>
				<?php endif; ?>
					</div>
					<textarea name='body[]' class='large dontdisplay'></textarea>
				</div>
			</div>
		</div>
		<div id = '' class = 'input-section body-roman'>
			<div class = 'wysiwyg-container'>
				<label class = 'caption-roman'>Note</label><br>
				<div class = 'wysiwyg-text-editor wysiwyg-editor'>
					<span class="toolbar dontdisplay">
						<?php if ($user == 'admin'): ?>
							<a id="" class='tool-html right' href="#null" >html</a>
							<a id="" class='tool-txt right dontdisplay' href="#null" >done.</a>
						<?php endif; ?>
						<a class='tool-bold' href="#null" onclick="document.execCommand('strong',false,null);">bold</a>
		                <a class='tool-italic' href="#null" onclick="document.execCommand('em',false,null);">italic</a> 
		                <a class='tool-indent' href="#null" onclick="indent();">indent</a>
		                <a class='tool-reset' href="#null" onclick="reset();">&nbsp;&times;&nbsp;</a>
		                &nbsp;
		                <a class='tool-link' href="#null" onclick="link();">link</a>
					</span>

					<?php if ($user == 'guest'): ?>
						<div name='note' class='large editable' contenteditable='false' id='' onclick="" style="">
					<?php else: ?>
						<div name='note' class='large editable' contenteditable='true' id='' onclick="" style="">
					<?php endif; ?>
					</div>
					<textarea name='note' class='large dontdisplay'></textarea>
				</div>
			</div>
		</div>
		<?
		for ($j = 0; $j < $max_uploads; $j++)
		{
			?><div class="image-upload caption-roman">
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
				name=''
				value='Add Object'
			>
		</div>
	</form>
	<script>
		var submit_btn = document.querySelector('.button-container input[type="submit"]');
		var sWysiwyg_container = document.getElementsByClassName('wysiwyg-container');
		var sWysiwyg_editor = document.getElementsByClassName('wysiwyg-editor');
		[].forEach.call(sWysiwyg_container, function(el, i){
			addWysiwygContainerListeners(el);
		});
		[].forEach.call(sWysiwyg_editor, function(el, i){
			addWysiwygEditorListeners(el);
		});

		submit_btn.addEventListener('click', function(e){
			e.preventDefault();
			commitAll();
			setTimeout(function(){
				var add_form = document.getElementById('add-form');
				add_form.submit();
			}, 0);
		});
		window.addEventListener('click', function(e){
			if (outsideClick(e, sWysiwyg_editor)) {
		   		resignImageContainer();
				hideToolBars();
		   }
		});
	</script>
	<? }else{ 

		$f = array();
		// objects
		foreach($vars as $var){
			if($var == 'name1')
			{
				$name1 = $_POST['event-title'];
				if(!empty($_POST['event-tag']))
					$name1 = $_POST['event-tag'] . '[tagdivider]' . $name1;
				if(!empty($_POST['event-subtitle']))
					$name1 = $name1 . '[subtitledivider]' . $_POST['event-subtitle'];
				$f[$var] = addslashes($name1);
			}
			elseif($var == 'deck')
				$f[$var] = addslashes($_POST['event-location']);
			elseif($var == 'begin')
				$f[$var] = addslashes($_POST['event-time']);
			elseif($var == 'body')
			{
				$body_arr = $_POST['body'];
				$sectionTitle_arr = $_POST['section-title'];
				$bodyString = '';
				foreach($body_arr as $key => $b)
				{
					$isEmpty = true;
					if( !empty($sectionTitle_arr[$key]) ){
						$bodyString .= $sectionTitle_arr[$key] . '[sectiontitledivider]';
						$isEmpty = false;
					}
					if( !empty($b) ){
						$bodyString .= $b;
						$isEmpty = false;
					}
					if(!$isEmpty && $key != count($body_arr) -1 )
						$bodyString .= '[sectiondivider]';
				}
				$f[$var] = $bodyString;
			}
			elseif($var == 'url')
			{
				$f[$var] = addslashes(slug($_POST['event-title']));
			}
		}

		// var_dump($f);
		$siblings = $oo->children_ids($fromid);
		$toid = insert_object($f, $siblings);
		if($toid)
		{
			// wires
			$ww->create_wire($fromid, $toid);
			// media
			process_media($toid);
		?><div>Record added successfully.</div><?
		}
		else
		{
		?><div>Record not created, please <a href="<? echo $js_back; ?>">try again.</a></div><?
		}
	 } ?>
</section>
