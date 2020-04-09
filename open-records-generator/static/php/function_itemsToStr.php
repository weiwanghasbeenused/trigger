<?
// merge list into ready-display html;
function itemsToStr($items = array(), $className, $var){
	$output = '';
	foreach($items as $key => $item){
		if(!empty($item[0]) && $item[0] != "(title)"){
			$output .= '<a class = "'.$className.'" href = "'.$item[1].'">'.$item[0].'</a><br>';
		}
	}
	return $output;
}