<?
// merge list into ready-display html;
function strToItems($str){
	$temp = stripSlashes(htmlspecialchars($str));
	$pattern = [htmlspecialchars('<a class = "reference_link" href = '), htmlspecialchars('</a>'), htmlspecialchars("'")];
	$replacement = ["", "",""];
	$temp = str_replace($pattern,$replacement,$temp);
	return explode(htmlspecialchars("<br>"), $temp);
}