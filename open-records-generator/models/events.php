<?
class Events extends Objects
{
	// const table_name = "objects";
	public function get_upcoming()
	{	
		global $db;
		$sql_upcoming = "SELECT id FROM objects WHERE url = 'upcoming' AND active = '1'";
		$res = $db->query($sql_upcoming);
		$upcoming_id = $res->fetch_assoc();
		$res->close();
		$upcoming_id = $upcoming_id["id"];
		$fields = array("objects.*");
		$tables = array("objects", "wires");
		$where	= array("wires.fromid = '".$upcoming_id."'",
						"wires.active = 1",
						"wires.toid = objects.id",
						"objects.active = '1'");
		$order 	= array("objects.event_date", "objects.begin", "objects.end", "objects.name1");
		$upcoming_events = $this->get_all($fields, $tables, $where, $order);
		return $upcoming_events;
	}
	public function get_upcoming_tn($o = NULL)
	{
		$fields = array("*");
		$tables = array("media");
		$where 	= array("object = '".$upcoming_events[0]['id']."'", 
						"active = '1'");
		$order 	= array("rank", "modified", "created", "id");
		
		return $this->get_all($fields, $tables, $where, $order);
	}
	public function get_archive()
	{	
		global $db;
		$sql_archive = "SELECT id FROM objects WHERE url = 'archive' AND active = '1'";
		$res = $db->query($sql_archive);
		$archive_id = $res->fetch_assoc();
		$res->close();
		$archive_id = $archive_id["id"];
		$fields = array("objects.*");
		$tables = array("objects", "wires");
		$where	= array("wires.fromid = '".$archive_id."'",
						"wires.active = 1",
						"wires.toid = objects.id",
						"objects.active = '1'");
		$order 	= array("objects.event_date", "objects.begin", "objects.end", "objects.name1");
		$archive_events = $this->get_all($fields, $tables, $where, $order, '', TRUE);
		return $archive_events;
	}
	public function get_archive_tn($o = NULL)
	{
		$fields = array("*");
		$tables = array("media");
		$where 	= array("object = '".$archive_events[0]['id']."'", 
						"active = '1'");
		$order 	= array("rank", "modified", "created", "id");
		
		return $this->get_all($fields, $tables, $where, $order);
	}
	public function get_location($index)
	{	
		$location_list_path = __DIR__."/../json/location.json";
		$location_fulllist = json_decode(file_get_contents($location_list_path), true);
		$list_name = $index;
		return $location_fulllist[$list_name];
	}
	public static function insertReference($arr)
	{
		global $db;
		$dt = date(self::MYSQL_DATE_FMT);
		$arr["created"] = "'".$dt."'";
		$arr["modified"] = "'".$dt."'";

		$keys = implode(", ", array_keys($arr));
		$values = implode(", ", array_values($arr));
		$sql = "INSERT INTO " . static::table_name . " (";
		$sql .= $keys . ") VALUES(" . $values . ")";
		$db->query($sql);
		return $db->insert_id;
	}
	public static function update_reading($id, $arr)
	{
		global $db;
		$dt = date(self::MYSQL_DATE_FMT);
		$arr["modified"] = "'".$dt."'";
		foreach($arr as $key => $value)
			$pairs[] = $key."=".$value;
		$z = implode(", ", $pairs);
		$sql = "UPDATE ".static::table_name." 
				SET ".$z."
				WHERE id = '".$id."'";
		return $db->query($sql);
	}
}
?>