<?
// merge list into ready-display html;
function strToItems($str){
	$output = array();
	$pattern = ['<a class = "reference_link" href = ', '</a>', '"'];
	$str = str_replace($pattern,'',$str);
	$output = explode('<br>',$str);
	foreach($output as &$op)
		$op = explode('>', $op);
	return $output;
}