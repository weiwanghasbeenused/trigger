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
			$resource_from_name[$key][] = $oo->name(intval($tf));
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
</script>

