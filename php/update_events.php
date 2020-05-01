<?
// require_once('../open-records-generator/config/config');
$config = $_SERVER['DOCUMENT_ROOT']."/open-records-generator/config/config.php";
require_once($config);
$db = db_connect("guest");
$oo = new Objects();
$ww = new Wires();

$upcoming_id = end( $oo->urls_to_ids(array('events', 'upcoming')) );
$archive_id = end( $oo->urls_to_ids(array('events', 'archive')) );

$upcoming_events = $oo->children($upcoming_id);
$now = date('Y-m-d');

foreach( $upcoming_events as $ue ){
	$this_date = date('Y-m-d', strtotime( $ue['event_date']) );
	if( $now > $this_date){
		$this_id = $ue['id'];
		$this_wire_id = intval( $ww->get_wire($upcoming_id, $this_id)['id'] );
		$arr["fromid"] = $archive_id;
		$ww->update($this_wire_id, $arr);
	}else{
		break;
	}
}
