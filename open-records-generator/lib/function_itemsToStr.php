<?
// merge list into ready-display html;
function itemsToStr($items = array(), $className = 'reference_link', $var = null){
	$output = '';
	foreach($items as $key => $item){
		if(!empty($item[0]) && $item[0] != "(title)"){
			$output .= '<a class = "'.$className.'" target = "_blank" href = "'.$item[1].'">'.$item[0].'</a><br>';
		}
	}
	return $output;
}