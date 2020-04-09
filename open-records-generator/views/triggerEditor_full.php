<!-- toolbox -->
<div id="<?echo $var;?>-toolbar" class="toolbar">
	<a id="<? echo $var; ?>-html" class='right tool_show' href="" onclick="sethtml('<? echo $var; ?>');">html</a>
	<a id="<? echo $var; ?>-txt" class='right tool_hide' href="" onclick="showrich('<? echo $var; ?>');">done.</a>
	<a id="<? echo $var; ?>-back" class='tool_show' href="" onclick="undo('<? echo $var; ?>');">Undo &#8617;</a>
	<a id="<? echo $var; ?>-forward" class='tool_show' href="" onclick="redo('<? echo $var; ?>');">&#8618; Redo</a>
	<a id="<? echo $var; ?>-link" class='tool_show' href="" onclick="link('<? echo $var; ?>');">link</a>
	<? if($var != 'upcoming_text'){ ?>
	<a id="<? echo $var; ?>-image" class='tool_show' href="" onclick="image('<? echo $var; ?>');">image</a>
	<? } ?>
	<? if($var == 'body'){ ?>
	<a id="<? echo $var; ?>-subtitle" class='tool_show' href="" onclick="addTag('<? echo $var; ?>','h4', 'subtitle');">subtitle</a>
	<? }elseif($var == 'qanda'){ ?>
	<a id="<? echo $var; ?>-qandaname" class='tool_show' href="" onclick="addTag('<? echo $var; ?>','h4', 'qandaname');">Q & A name</a>
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
				
				$addTag = "addTag('" .$var. "', 'img', 'img_ctner_temp', '".$thisUrl."', '".$thisCaption."')";
				echo '<div class="image-container" id="'. m_pad($medias[$i]['id']) .'-'. $var .'" onclick = "'.$addTag.'"><img src="'. $medias[$i]['display'] .'"></div>';
			}
		}
		?>
		</div>
	</div>
</div>
<? if($item[$var]){ ?>
<div name='<? echo $var; ?>' class='large editable' contenteditable='true' id='<? echo $var; ?>-editable' onclick="showToolBar('<? echo $var; ?>'); resetViews('<? echo $var; ?>');" style="display: block;"><?
        echo $item[$var];
?></div>
<textarea name='<? echo $var; ?>' class='large hidden' id='<? echo $var; ?>-textarea' onclick="" onblur=""><?
    if($item[$var])
        echo $item[$var];
?></textarea>
<? }else{ ?>
<textarea name='<? echo $var; ?>' class='large hidden' id='<? echo $var; ?>-textarea' onclick="" onblur=""></textarea>
<? } ?>

<script>
	addListeners('<?echo $var; ?>');
	// for triggerEditor
	
	addListeners_selection('<?echo $var; ?>');
	addListeners_paste('<?echo $var; ?>');
	<? if($item[$var]) ?>
	unWrappingTemp('<?echo $var; ?>');
	<? endif ?>
</script>