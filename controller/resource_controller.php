<?
$children = $oo->children($uu->id);
$resource_list = array();
$resource_from_name = array();
$resource_from_link = array();

foreach($children as $key => $child){
	$resource_list[] = $child['reading'];
	if($child['reading_fromid'] !== null){
		$this_fromid = explode(',', str_replace('', ' ', $child['reading_fromid']));
		foreach ( $this_fromid as $tf) {
			$resource_from_name[$key][] = $oo->name(intval($this_fromid));
			$resource_from_link[$key][] = '/events/'.$oo->ids_to_urls(array(intval($this_fromid)))[0];
		}
	}else{
		$resource_from_name[$key] = null;
		$resource_from_link[$key] = null;
	}
}
require_once("views/resource.php");
?>
<script type = "text/javascript">
	var sMain_ctner = document.getElementById("main_ctner_resource");
	var html = sMain_ctner.innerHTML;
	sMain_ctner.innerHTML = html.replace(/<br\s*[\/]?>/gi, '');
	var sResource_item = document.getElementsByClassName('resource_item');
	var sItem_translate = [];
	var sItem_rotation = [];
	function randn_bm() {
	    var u = 0, v = 0;
	    while(u === 0) u = Math.random(); //Converting [0,1) to (0,1)
	    while(v === 0) v = Math.random();
	    return Math.sqrt( -2.0 * Math.log( u ) ) * Math.cos( 2.0 * Math.PI * v );
	}
	Array.prototype.forEach.call(sResource_item, function(el,i){
		var random_rotation = 10*randn_bm()-5;
		var random_x = parseInt((2.4*randn_bm()-1)*100)/100;
		var random_y = parseInt((2.4*randn_bm()-0.8)*100)/100;
		var thisTranslate = 'translate('+random_x+'vw, '+random_y+'vw)';
		var thisRotation = 'rotate(' + random_rotation +'deg)';
		sItem_translate.push( thisTranslate );
		sItem_rotation.push(thisRotation);
		el.style.transform = thisTranslate +' ' + thisRotation;
		el.addEventListener('mouseleave', function(){
			el.style.transform = sItem_translate[i]+' '+sItem_rotation[i];
		});
		el.addEventListener('mouseenter', function(){
			el.style.transform = sItem_translate[i];
		});
	});
</script>

