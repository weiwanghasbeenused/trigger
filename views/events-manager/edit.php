<?
	$eventType = $uri[2];
	$thisUrl = $uri[3];
	$this_id = end($oo->urls_to_ids(array($eventType, $thisUrl)));
	$fromid = end($oo->urls_to_ids(array($eventType)));
	$nav_items = array(
		array(
			'name1' => $eventType,
			'url' => '/events-manager/'.$eventType,
			'class' => ''
		)
	);
	$item = $oo->get($this_id);
	$event_name1 = prepareTitle($item['name1'], true);
	$event_tag_arr = $event_name1['tag'];
	$event_title = $event_name1['title'];
	$event_subtitle = $event_name1['subtitle'];

	// var_dump($item['body']);
	$event_body = empty($item['body']) ? array(array('sectiontitle'=>'','sectioncontent'=>array(array('content-type'=>'text','content'=>'')))) : prepareBody_edit($item['body']);
	$vars = array("name1", "deck", "body", "notes",  "url", "rank", "begin", "end");
	$vars_unEditable = array("url", "rank", "end", "notes");
	$var_info = array();

	function update_object(&$old, &$new, $siblings, $vars)
	{
		global $oo;

		// set default name if no name given
		if(!$new['name1'])
			$new['name1'] = "untitled";

		// add a sort of url break statement for urls that are already in existence
		// (and potentially violate our new rules?)
	    // urldecode() is for query strings, ' ' -> '+'
	    // rawurldecode() is for urls, ' ' -> '%20'
		$url_updated = rawurldecode($old['url']) != $new['url'];
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

?><section id = 'main'>
	<?
		if($rr->action != "update"){
			$form_url = implode($uri, '/');
		// get existing image data
		$medias = $oo->media($item['id']);
		$num_medias = count($medias);
		for($i = 0; $i < $num_medias; $i++)
		{
			$m_padded = "".m_pad($medias[$i]['id']);
			$medias[$i]["fileNoPath"] = '/media/'.$m_padded.".".$medias[$i]["type"];
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
	?>
	<script src = '/static/js/events-manager-function.js'></script>
		<form
			enctype="multipart/form-data"
			action="<? echo $form_url; ?>"
			method="POST"
			id = 'edit-form'
		>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-type' class = 'caption-roman'>Event Type</label>
			<input id = 'add-event-type' name = 'event-type' type = 'text' value = '<?= $event_tag_arr[0]; ?>'>
		</div>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-title' class = 'caption-roman'>Title</label>
			<input id = 'add-event-title' name = 'event-title' type = 'text' value = '<?= $event_title; ?>'>
		</div>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-subtitle' class = 'caption-roman'>Subtitle</label>
			<input id = 'add-event-subtitle' name = 'event-subtitle' type = 'text' value = '<?= $event_subtitle; ?>'>
		</div>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-time' class = 'caption-roman'>Event Time (ex: 2021-12-25 18:00)</label>
			<input id = 'add-event-time' name = 'event-time' type = 'text' value = '<?= $item['begin']; ?>'>
		</div>
		<div class = 'input-section body-roman'>
			<label for = 'add-event-location' class = 'caption-roman'>Location</label>
			<input id = 'add-event-location' name = 'event-location' type = 'text' value = '<?= $item['deck']; ?>'>
		</div>
		<div id = 'input-section-body' class = 'input-section body-roman'>
			<? if( !empty($event_body) ){
				foreach($event_body as $key => $b)
				{
					?><div class = 'body-section wysiwyg-container'>
						<? if($key != 0){
							?><a href ='#null' class = 'btn-delete-section tool-btn alert-btn'>&cross;&cross; Delete the section</a><?
						} ?>
						<label class = 'section-title-label caption-roman'>Section <?= $key+1; ?> - Title</label>
						<input class = 'section-title-input' name = 'section-title[]' type = 'text' value = '<?= $b['sectiontitle']; ?>'>
						<label class = 'body-text-label caption-roman'>Section <?= $key+1; ?> - Content</label><br>

						<? 
						foreach($b['sectioncontent'] as $sec_content){
							
							if($sec_content['content-type'] == 'text')
							{
								?><div class = 'wysiwyg-text-editor wysiwyg-editor'>
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
									<div name='body[]' class='large editable' contenteditable='false' id='' onclick="" style=""><?= $sec_content['content']; ?>
								<?php else: ?>
									<div name='body[]' class='large editable' contenteditable='true' id='' onclick="" style=""><?= $sec_content['content']; ?>
								<?php endif; ?>
								</div>
								<textarea name='body[]' class='large dontdisplay'></textarea>
							</div><?
							}
							elseif($sec_content['content-type'] == 'image')
							{
								?><div class = 'wysiwyg-image-editor wysiwyg-editor'>
									<span class='imagecontainer' style="background-color: #999;">
										<span style="color: white;">choose an image...</span>
										<div class='imagebox'>
											<?

											for($i = 0; $i < $num_medias; $i++) {
												if ($medias[$i]["type"] != "pdf" && $medias[$i]["type"] != "mp4" && $medias[$i]["type"] != "mp3") {
													$this_cleanedCaption_arr = getCleanCaption($medias[$i]['caption']);
													echo '<div class="image-container" img-path="'. $medias[$i]['fileNoPath'] . '"  alt = "'.$medias[$i]['caption'].'" ><img src="'. $medias[$i]['display'] .'" alt = "'.$this_cleanedCaption_arr['cleanedCaption'].'" ></div>';
												}
											}
											?>
										</div>
									</span>
									<a href = '#null' class = 'btn-delete-image tool-btn red-btn'>&cross; Delete this Image Block</a>
									<div class = 'editable image-holder'><?= $sec_content['content']; ?></div>
									<textarea name='body[]' class='large dontdisplay'></textarea>
								</div>
								<?
							}
						} ?>
						<span class = 'body-content-control'>
							<a href = '#null' class = 'btn-add-body-image tool-btn'>&sext; Add an Image Block</a>
							<a href = '#null' class = 'btn-add-body-text tool-btn'>&sext; Add a Text Block</a>
						</span> 
					</div><?
				}
			} ?>
			<div id = 'body-section-toolbar'><a href = '#null' id = 'btn-add-body-section' class = 'tool-btn'>&sext;&sext; Add a body section</a></div>
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
		<input id = 'body_formatted' name = 'body_formatted' type = 'hidden'>
		<!-- template for .wysiwyg-container -->
		<div id = 'wysiwyg-container-template' class = 'wysiwyg-container edit-block-template'>
			<a class = 'btn-delete-section tool-btn alert-btn'>&cross;&cross; Delete the section</a>
			<label class = 'section-title-label caption-roman'>Section 1 - Title </label>
			<input class = 'section-title-input' name = 'section-title[]' type = 'text'>
			<label class = 'section-content-label caption-roman'>Section 1 - Content</label><br>
			<div class = 'wysiwyg-text-editor wysiwyg-editor'>
				<div body_section = '1' class="toolbar dontdisplay">
					<?php if ($user == 'admin'): ?>
						<a class='tool-html right' href="#null" >html</a>
						<a class='tool-txt right dontdisplay' href="#null" >done.</a>
					<?php endif; ?>
					<a class='tool-bold' href="#null" onclick="document.execCommand('strong',false,null);">bold</a>
	                <a class='tool-italic' href="#null" onclick="document.execCommand('em',false,null);">italic</a> 
	                <a class='tool-indent' href="#null" onclick="indent();">indent</a>
	                <a class='tool-reset' href="#null" onclick="reset();">&nbsp;&times;&nbsp;</a>
	                &nbsp;
	                <a class='tool-link' href="#null" onclick="link();">link</a>
				</div>

				<?php if ($user == 'guest'): ?>
					<div name='' class='large editable' contenteditable='false' id='' onclick="" style="">
				<?php else: ?>
					<div name='' class='large editable' contenteditable='true' id='' onclick="" style="">
				<?php endif; ?>
				</div>
				<textarea name='' class='large dontdisplay'></textarea>
			</div>
			<span class = 'body-content-control'>
				<a href = '#null' class = 'btn-add-body-image tool-btn'> Add an Image Block</a>
				<a href = '#null' class = 'btn-add-body-text tool-btn'>Add a Text Block</a>
			</span>
		</div>
			
		<!-- template for image section -->
		<div id = 'wysiwyg-image-editor-template' class = 'wysiwyg-image-editor displaying-imagecontainer displaying-toolbar edit-block-template wysiwyg-editor'>
			<div class='imagecontainer' style="background-color: #999;">
				<span style="color: white;">insert an image...</span>
				<div class='imagebox'>
					<?
					for($i = 0; $i < $num_medias; $i++) {
						if ($medias[$i]["type"] != "pdf" && $medias[$i]["type"] != "mp4" && $medias[$i]["type"] != "mp3") {
							$this_cleanedCaption_arr = getCleanCaption($medias[$i]['caption']);
							echo '<div class="image-container" img-path="'. $medias[$i]['fileNoPath'] . '"  alt = "'.$medias[$i]['caption'].'" ><img src="'. $medias[$i]['display'] .'" alt = "'.$this_cleanedCaption_arr['cleanedCaption'].'" ></div>';
						}
					}
					?>
				</div>
			</div>
			<a href = '#null' class = 'btn-delete-image tool-btn red-btn'>&cross; Delete this Image Block</a>
			<div class = 'editable image-holder'><figure class = 'body-image-holder'><img><figcaption class = 'caption caption-roman'></figcaption></figure></div>
			<textarea name='' class='large dontdisplay'></textarea>
		</div>
		<?
		$thumbnailOrder = null;
		// show existing images
		for($i = 0; $i < $num_medias; $i++)
		{
			$im = str_pad($i+1, 2, "0", STR_PAD_LEFT);
			$image_id = $medias[$i]['id'];
		?><div class="existing-image">
			<div class="field-name caption-roman">Image <? echo $im; ?></div>
			<div class='preview'>
				<a href="<? echo $medias[$i]['file']; ?>" target="_blank">
					<img src="<? echo $medias[$i]['display']; ?>">
				</a>
			</div>
			<textarea name="captions[]" onclick="hideToolBars(); resetViews();" form="edit-form"
				<?php if ($user == 'guest'): ?>
					disabled = "disabled"
				<?php endif; ?>
			><?
				$this_cleanedCaption_arr = getCleanCaption($medias[$i]["caption"]);
				echo $this_cleanedCaption_arr['cleanedCaption'];
			?></textarea>
			<span>rank</span>
			<select name="ranks[<? echo $i; ?>]" form="edit-form"
				<?php if ($user == 'guest'): ?>
					disabled = "disabled"
				<?php endif; ?>
				><?
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
					type="checkbox"
					name="deletes[<? echo $i; ?>]"
					form="edit-form"
					<?php if ($user == 'guest'): ?>
						disabled = "disabled"
					<?php endif; ?>
				>
			delete image</label>
			<label>
				<input
					type="radio"
					name="isThumbnail"
					form="edit-form"
					<?= $this_cleanedCaption_arr['isThumbnail'] ? 'checked' : ''; ?>
					image-id="<?= $image_id; ?>"
				>
			is thumbnail</label>
			<label>
			<input
				type="hidden"
				name="medias[<? echo $i; ?>]"
				value="<? echo $medias[$i]['id']; ?>"
				form="edit-form"
			>
			<input
				type="hidden"
				name="types[<? echo $i; ?>]"
				value="<? echo $medias[$i]['type']; ?>"
				form="edit-form"
			>
		</div>
		
		<?php
		}
		?><input type="hidden" name="thumbnailOrder" value="<?= $thumbnailOrder; ?>"><?
		// upload new images
		if ($user != 'guest') {
			for($j = 0; $j < $max_uploads; $j++)
			{
				$im = str_pad(++$i, 2, "0", STR_PAD_LEFT);
			?><div class="image-upload caption-roman">
				<span class="field-name">Image <? echo $im; ?></span>
				<span>
					<input type="file" name="uploads[]" form="edit-form">
				</span>
				<!--textarea name="captions[]"><?php
						echo $medias[$i]["caption"];
				?></textarea-->
			</div><?php
			}
		} ?>
		<? foreach($vars_unEditable as $var_uneditable){
			?><input type = 'hidden' name="<?= $var_uneditable; ?>" value = '<?= $item[$var_uneditable]; ?>'><?
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
			>
			<input
				type='submit'
				name=''
				value='Update Object'
			>
		</div>
	</form>
	<script>
		// dealing with templates
		var sInput_section_body = document.getElementById('input-section-body');
		var wysiwyg_container_template = document.getElementById('wysiwyg-container-template').cloneNode(true);
		var wysiwyg_text_editor_template = wysiwyg_container_template.querySelector('.wysiwyg-text-editor');
		var wysiwyg_image_editor_template = document.getElementById('wysiwyg-image-editor-template').cloneNode(true);

		wysiwyg_container_template.id = '';
		wysiwyg_container_template.classList.remove('edit-block-template');
		wysiwyg_container_template.classList.add('body-section');
		var temp_editable = wysiwyg_container_template.querySelector('.editable');
		temp_editable.setAttribute('name', 'body[]');
		var temp_textarea = wysiwyg_container_template.querySelector('textarea');
		temp_textarea.setAttribute('name', 'body[]');

		wysiwyg_image_editor_template.id = '';
		wysiwyg_image_editor_template.classList.remove('edit-block-template');
		var temp_editable = wysiwyg_image_editor_template.querySelector('.editable');
		temp_editable.setAttribute('name', 'body[]');
		var temp_textarea = wysiwyg_image_editor_template.querySelector('textarea');
		temp_textarea.setAttribute('name', 'body[]');
		
		// clones 
		var wysiwyg_container_clone = wysiwyg_container_template.cloneNode(true);
		var wysiwyg_text_editor_clone = wysiwyg_text_editor_template.cloneNode(true);
		var wysiwyg_image_editor_clone = wysiwyg_image_editor_template.cloneNode(true);

		var sBtn_add_body_section = document.getElementById('btn-add-body-section');
		var sBtn_add_body_image = document.getElementsByClassName('btn-add-body-image');
		var sBtn_add_body_text = document.getElementsByClassName('btn-add-body-text');
		
		var sWysiwyg_container = document.getElementsByClassName('wysiwyg-container');
		var sBody_section = document.getElementsByClassName('body-section');
		var sBody_section_toolbar = document.getElementById('body-section-toolbar');
		var section_number = sBody_section.length;
		var sWysiwyg_editor = document.getElementsByClassName('wysiwyg-editor');

		[].forEach.call(sWysiwyg_container, function(el, i){
			if(!el.classList.contains('edit-block-template'))
				addWysiwygContainerListeners(el)
		});
		[].forEach.call(sWysiwyg_editor, function(el, i){
				addWysiwygEditorListeners(el)
		});

		sBtn_add_body_section.addEventListener('click', function(){
			section_number++;
			var sSection_title_label = wysiwyg_container_clone.querySelector('.section-title-label');
			var sBody_text_label = wysiwyg_container_clone.querySelector('.section-content-label');
			sSection_title_label.innerText = 'Section '+section_number+' - Title ';
			sBody_text_label.innerText = 'Section '+section_number+' - Content ';
			sInput_section_body.insertBefore(wysiwyg_container_clone, sBody_section_toolbar);
			addWysiwygContainerListeners(wysiwyg_container_clone);
			var thisWysiwygEditor = wysiwyg_container_clone.querySelectorAll('.wysiwyg-editor');
			[].forEach.call(thisWysiwygEditor, function(el, i){
				addWysiwygEditorListeners(el);
			});
			wysiwyg_container_clone = wysiwyg_container_template.cloneNode(true);
			hideToolBars();
		});
		
		// [].forEach.call(sBtn_add_body_text, function(el, i){
		// 	el.addEventListener('click', function(){
		// 		hideToolBars();
		// 		setTimeout(function(){
		// 			el.parentNode.parentNode.insertBefore(wysiwyg_text_editor_clone, el.parentNode);
		// 			addListeners(wysiwyg_text_editor_clone);
		// 			wysiwyg_text_editor_clone = wysiwyg_text_editor_template.cloneNode(true);
		// 		}, 0);
		// 	});
		// });

		
		window.addEventListener('click', function(e){
			if (outsideClick(e, sWysiwyg_editor)) {
		   		resignImageContainer();
				hideToolBars();
		   }
		});
		var sIsThumbnail = document.querySelectorAll('input[name="isThumbnail"]');

		var sBody_formatted = document.getElementById('body_formatted');
		var sSubmitBtn = document.querySelector('.button-container input[type="submit"]');
		sSubmitBtn.addEventListener('click', function(e){
			e.preventDefault();
			commitAll();
			var body_formatted = '';
			sBody_section = document.getElementsByClassName('body-section');
			[].forEach.call(sBody_section, function(el, i){
				var this_body_formatted = '';
				var this_section_title = el.querySelector('input[name="section-title[]"]');
				if(this_section_title.value)
					this_body_formatted += this_section_title.value + '[sectiontitledivider]';
				var this_section_content = el.querySelectorAll('textarea[name="body[]"]');
				[].forEach.call(this_section_content, function(content_el, content_i){
					if(content_el.value){
						var this_content_value = content_el.value;
						while(this_content_value.charCodeAt(0) == 9 || this_content_value.charCodeAt(0) == 10)
						{
							this_content_value = this_content_value.substring(1);
						}
						while(this_content_value.charCodeAt(this_content_value.length - 1) == 9 || this_content_value.charCodeAt(this_content_value.length - 1) == 10)
						{
							this_content_value = this_content_value.substring(0, this_content_value.length - 2);
						}
						if(this_content_value){
							if(this_content_value.includes('body-image-holder'))
								this_content_value = '[imagedivider]' + this_content_value + '[endimagedivider]';
							this_body_formatted += this_content_value;
						}
					}
				});
				if(this_body_formatted !== ''){
					this_body_formatted += '[sectiondivider]';
					body_formatted += this_body_formatted;
				}
			});

			sBody_formatted.value = body_formatted;
			// console.log(body_formatted);
			var sThumbnailOrder = document.querySelector('input[name="thumbnailOrder"]');
			[].forEach.call(sIsThumbnail, function(el,i){
				if(el.checked)
					sThumbnailOrder.value = el.getAttribute('image-id');
			});
			setTimeout(function(){
				var edit_form = document.getElementById('edit-form');
				edit_form.submit();
			}, 0);
		});

		var sCancelBtn = document.querySelector('.button-container input[name="cancel"]');
		sCancelBtn.addEventListener('click', function(){
			location.href="/<?= $uri[1].'/'.$uri[2]; ?>";
		});
	</script>
	<? }else{ 

		$new = array();
		// objects
		foreach($vars as $var)
		{
			if($var == 'name1')
			{
				$name1 = $_POST['event-title'];
				if(!empty($_POST['event-type']))
					$name1 = $_POST['event-type'] . '[tagdivider]' . $name1;
				if(!empty($_POST['event-subtitle']))
					$name1 = $name1 . '[subtitledivider]' . $_POST['event-subtitle'];
				$new[$var] = addslashes($name1);
			}
			elseif($var == 'deck')
				$new[$var] = addslashes($_POST['event-location']);
			elseif($var == 'begin')
				$new[$var] = addslashes($_POST['event-time']);
			elseif($var == 'body')
			{
				$body_formatted = $_POST['body_formatted'];
				$new[$var] = addslashes($body_formatted);
			}
			else
				$new[$var] = addslashes($rr->$var);
			$item[$var] = addslashes($item[$var]);
		}
		$siblings = $oo->siblings($item['id']);
		$updated = update_object($item, $new, $siblings, $vars);

		// process new media
		$updated = (process_media_wysiwyg($item['id']) || $updated);
		
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
	    if (is_array($rr->captions)) {
		    $num_captions = sizeof($rr->captions);
		    if (sizeof($rr->medias) < $num_captions)
			    $num_captions = sizeof($rr->medias);
	    }

	    for ($i = 0; $i < $num_captions; $i++)
		{

			unset($m_arr);
			$m_id = $rr->medias[$i];

			$isThumbnail = $_POST['thumbnailOrder'] == $m_id ? 'isThumbnail' : '';
			
			$caption = addslashes('[' . $isThumbnail . ']' . $rr->captions[$i]);
			$rank = addslashes($rr->ranks[$i]);
			$m = $mm->get($m_id);
			if($m["caption"] != $caption)
				$m_arr["caption"] = "'".$caption."'";
			if($m["rank"] != $rank)
				$m_arr["rank"] = "'".$rank."'";
			if($m_arr)
			{
				$arr["modified"] = "'".date("Y-m-d H:i:s")."'";
				$updated = $mm->update($m_id, $m_arr);
			}
		}
		// die();

		if($updated)
		{
		?><div>Record successfully updated.</div><?
		}
		else
		{
		?><div>Nothing was edited, therefore update not required.</a></div><?
		}
	 } ?>
</section>
