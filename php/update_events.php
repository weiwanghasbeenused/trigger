<?
// require_once('../open-records-generator/config/config');
// set_include_path('.');
$config = "config_for_cronjob.php";
require_once($config);
$db = db_connect("guest");
$oo = new Objects();
$ww = new Wires();

$upcoming_id = $oo->urls_to_ids(array('events', 'upcoming'));
$upcoming_id = end( $upcoming_id );
$archive_id = $oo->urls_to_ids(array('events', 'archive'));
$archive_id = end( $archive_id );

$upcoming_events = $oo->children($upcoming_id);
$now = date('Y-m-d');
// var_dump($upcoming_events);
foreach( $upcoming_events as $ue ){
	$this_date = date('Y-m-d', strtotime( $ue['event_date']) );
	echo $this_date."\n";
	if( $now > $this_date){
		$this_id = $ue['id'];
		$this_wire_id = intval( $ww->get_wire($upcoming_id, $this_id)['id'] );
		$arr["fromid"] = $archive_id;
		$ww->update($this_wire_id, $arr);
	}
}
