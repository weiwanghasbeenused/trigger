<?
// merge list into ready-display html;
function strToItems($str){
	$output = array();
	$pattern = ['<a class = "reference_link" target = "_blank" href = ', '</a>', '"'];
	$str = str_replace($pattern,'',$str);
	$output = explode('<br>',$str);
	foreach($output as &$op)
		$op = explode('>', $op);
	return $output;
}
function strToItems2($str){
	$output = array();
	$pattern = [htmlspecialchars('<a class = "reference_link" target = "_blank" href = '), htmlspecialchars('</a>'), htmlspecialchars('"')];
	$str = stripslashes( htmlspecialchars($str) );
	$str = str_replace($pattern,'',$str);
	$output = explode(htmlspecialchars('<br>'),$str);
	foreach($output as &$op){
		if($op != '' && $op != 'NULL'){
			$op = explode(htmlspecialchars('>'), $op);
			$temp = $op[0];
			$op[0] = $op[1];
			$op[1] = $temp;
		}
	}

	return $output;
}