<!-- toolbox -->

<? 

?>
<div id="<?echo $var;?>-toolbar" class="toolbar">
	<a id="<? echo $var; ?>-html" class='right tool_show' href="#null" onclick="sethtml('<? echo $var; ?>');">html</a>
	<a id="<? echo $var; ?>-txt" class='right tool_hide' href="#null" onclick="showrich('<? echo $var; ?>');">done.</a>
	<a id="<? echo $var; ?>-format" class='right' href="#null" onclick="format('<? echo $var; ?>');">Format</a>
	<a id="<? echo $var; ?>-bold" class='tool_show' href="#null" onclick="document.execCommand('bold',false,null);">bold</a>
    <a id="<? echo $var; ?>-italic" class='tool_show' href="#null" onclick="document.execCommand('italic',false,null);">italic</a>
	<a id="<? echo $var; ?>-link" class='tool_show' href="#null" onclick="link('<? echo $var; ?>');">link</a>
	<a id="<? echo $var; ?>-image" class='tool_show' href="#null" onclick="image('<? echo $var; ?>');">image</a>
	<? if($var == 'main_two'){ ?>
	<a id="<? echo $var; ?>-subtitle" class='tool_show' href="#null" onclick="addTag('<? echo $var; ?>','h4', 'subtitle');">subtitle</a>
	<? }elseif($var == 'qanda'){ ?>
	<a id="<? echo $var; ?>-qandaname" class='tool_show' href="#null" onclick="addTag('<? echo $var; ?>','h4', 'qandaname');">Q & A name</a>
	<? }elseif($var == 'location'){ ?>
	<a id="<? echo $var; ?>-address" class='tool_show' href="#null" onclick="addTag('<? echo $var; ?>','div', 'address');">Address</a>
	<? } ?>
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

				$addTag = "addTag('" .$var. "', 'figure', 'img_ctner', '".$thisUrl."', '".$thisCaption."')";
				echo '<div class="image-container" id="'. m_pad($medias[$i]['id']) .'-'. $var .'" onclick = "'.$addTag.'"><img src="'. $medias[$i]['display'] .'"></div>';
			}
		}
		?>
		</div>
	</div>
</div>
<div name='<? echo $var; ?>' class='large editable' contenteditable='true' id='<? echo $var; ?>-editable' onclick="showToolBar('<? echo $var; ?>'); " ><?
    echo $item[$var];
?></div>
<textarea name='<? echo $var; ?>' class='large hidden' id='<? echo $var; ?>-textarea' onclick="" onblur=""><?
    echo $item[$var];
?></textarea>
<script>
	// var editable = document.getElementById('<? echo $var; ?>-editable');
	// var textarea = document.getElementById('<? echo $var; ?>-textarea');
	// editable.innerText = textarea.value;
	addListeners('<?echo $var; ?>');	
	addListeners_paste('<?echo $var; ?>');
	addListeners_selection('<?echo $var; ?>');
	unWrappingTemp('<?echo $var; ?>');
</script>
