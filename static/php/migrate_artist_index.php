<? 
$hostname = 'localhost';
$fromdatabase = 'trigger_local';
$todatabase = 'trigggggggger_clean';
$username = 'root';
$password = 'f3f4p4ax';
$vars = array("name1", "deck", "body", "notes",  "url", "rank", "begin", "end");

function insert($arr, $pdo, $table='objects')
{
	$dt = date("Y-m-d H:i:s");
	$arr["created"] = "'".$dt."'";
	$arr["modified"] = "'".$dt."'";
	$keys = array();
	foreach(array_keys($arr) as $k)
		$keys[] = "`".$k."`";
	$keys = implode(", ", $keys);
	$values = implode(", ", array_values($arr));
	$sql = "INSERT INTO " . $table . " (";
	$sql .= $keys . ") VALUES(" . $values . ")";
	// var_dump($sql);
	// die();
	$pdoStmt = $pdo->prepare($sql);
	$pdoStmt->execute();

	return $pdo->lastInsertId();
}

function create_wire($fromid, $toid, $pdo)
{
	$dt = date("Y-m-d H:i:s");
	$arr["fromid"] = $fromid;
	$arr["toid"] = $toid;
	return insert($arr, $pdo, 'wires');
}
require_once('../../open-records-generator/lib/lib.php');

try{
	$pdo = new PDO("mysql:host=$hostname; dbname=$fromdatabase; charset=utf8", $username, $password,
			array(PDO::ATTR_EMULATE_PREPARES=>false,
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_PERSISTENT => true
			)
	);
}
catch(PDOException $ex){
	echo "存取資料庫時發生錯誤，訊息:" . $ex->getMessage() . "<br>";
	echo "行號:" . $ex->getLine() . "<br>";
	echo "堆疊:" . $ex->getTraceAsString() . "<br>";
}

$get_artist_index_id = 'SELECT id FROM objects WHERE name1 LIKE "%artist index%"';
$pdoStmt = $pdo->prepare($get_artist_index_id);
$pdoStmt->execute();
$artist_index_id = $pdoStmt->fetchAll(PDO::FETCH_ASSOC)[0]['id'];
$get_artist_index_items = 'SELECT objects.* FROM objects, wires WHERE objects.active = "1" AND wires.active = "1" AND objects.id = wires.toid AND wires.fromid = "'.$artist_index_id.'"';
$pdoStmt = $pdo->prepare($get_artist_index_items);
$pdoStmt->execute();
$artist_index_items = $pdoStmt->fetchAll(PDO::FETCH_ASSOC);
$artist_index_items_new = array();

try{
	$pdo_new = new PDO("mysql:host=$hostname; dbname=$todatabase; charset=utf8", $username, $password,
			array(PDO::ATTR_EMULATE_PREPARES=>false,
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_PERSISTENT => true
			)
	);
}
catch(PDOException $ex){
	echo "存取資料庫時發生錯誤，訊息:" . $ex->getMessage() . "<br>";
	echo "行號:" . $ex->getLine() . "<br>";
	echo "堆疊:" . $ex->getTraceAsString() . "<br>";
}
$get_artist_index_id_new = 'SELECT id FROM objects WHERE name1 LIKE "%artist index%"';
$pdoStmt = $pdo_new->prepare($get_artist_index_id_new);
$pdoStmt->execute();
$artist_index_id_new = $pdoStmt->fetchAll(PDO::FETCH_ASSOC)[0]['id'];
// var_dump($artist_index_id_new);

$test = "'Hsu Che-Yu'";
// var_dump(addslashes($test));
// die();
foreach($artist_index_items as $key => $item)
{
	$item_new = array();
	$notes = '';
	if( $item['main_two'] !== null )
		$notes .= $item['main_two'].'<br>';
	if( $item['website'] !== null )
		$notes .= $item['website'];
	$notes = empty($notes) ? "null" : $notes;
	$item_new['notes'] = $notes;
	
	$body = '';
	if( $item['main_one'] !== null )
		$body .= $item['main_one'];
	$body = empty($body) ? "null" : $body;

	$item_new['body'] = $body;
	$item_new['name1'] = $item['name1'];
	$item_new['url'] = slug($item_new['name1']);
	$item_new['active'] = '1';
	foreach($vars as $var)
	{
		if(!isset($item_new[$var]))
			$item_new[$var] = "null";
		else
			$item_new[$var] = "'" . addslashes($item_new[$var]) . "'"; 
	}
	// die();
	// var_dump($item_new);
	// die();
	$insert_id = insert($item_new, $pdo_new);
	create_wire($artist_index_id_new, $insert_id, $pdo_new);

}

?>