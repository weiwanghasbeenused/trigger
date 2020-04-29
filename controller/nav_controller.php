<?
$menu_items = $oo->children(0);
foreach($menu_items as $key => $mi){
	if($mi['url'] == 'events'){
		$menu_items[$key]['submenu'] = $oo->children($mi['id']);
	}
}
require_once('views/nav.php');