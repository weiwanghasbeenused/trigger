<?

function search($fromid, $keyword){
  global $oo;
  global $ww;


  $keyword = preg_replace('/[^a-z0-9]+/i', ' ', $keyword);
  $keyword = addslashes($keyword);
  $keyword = strtolower($keyword);
  $keyword = str_replace(' ', '%', $keyword);
  $fields = array("objects.*");
  $tables = array("objects", "wires");
  $where  = array("objects.active = '1'",
                  "(LOWER(CONVERT(BINARY objects.name1 USING utf8mb4)) LIKE '%" . $keyword .
                  "%' OR LOWER(CONVERT(BINARY objects.main_one USING utf8mb4)) LIKE '%" . $keyword . 
                  "%' OR LOWER(CONVERT(BINARY objects.website USING utf8mb4)) LIKE '%" . $keyword . 
                  "%' OR LOWER(CONVERT(BINARY objects.main_two USING utf8mb4)) LIKE '%" . $keyword . "%')",
                  "wires.toid = objects.id",
                  "wires.fromid = '". $fromid . "'",
                  "wires.active = '1'");
  $order  = array("objects.name1");
  return $oo->get_all($fields, $tables, $where, $order);
}

function getUpcomingEvents($amount=false){
  global $oo;
  global $db;

  $upcoming_id = end($oo->urls_to_ids(array('upcoming')));

  $sql = "SELECT objects.id, objects.name1, objects.begin, objects.url, objects.end FROM objects, wires WHERE objects.active='1' AND wires.active='1' AND objects.name1 NOT LIKE '.%' AND objects.id = wires.toid AND wires.fromid = '".$upcoming_id."' ORDER BY objects.begin";
  if($amount)
    $sql .= " LIMIT 0, ".$amount;
  $res = $db->query($sql);
  if(!$res)
    throw new Exception($db->error);
  $items = array();
  while ($obj = $res->fetch_assoc())
    $items[] = $obj;
  $res->close();
  return $items;
}

function getArchiveEvents($amount=false){
  global $oo;
  global $db;

  $archive_id = end($oo->urls_to_ids(array('archive')));

  $sql = "SELECT objects.id, objects.name1, objects.begin, objects.url, objects.end FROM objects, wires WHERE objects.active='1' AND wires.active='1' AND objects.name1 NOT LIKE '.%' AND objects.id = wires.toid AND wires.fromid = '".$archive_id."' ORDER BY objects.begin DESC";
  if($amount)
    $sql .= " LIMIT 0, ".$amount;
  $res = $db->query($sql);
  if(!$res)
    throw new Exception($db->error);
  $items = array();
  while ($obj = $res->fetch_assoc())
    $items[] = $obj;
  $res->close();
  return $items;
}

function getEventThumbnail($media){
  $output = '';
  if(count($media) > 1)
  {
    foreach($media as $m)
    {
      if(strpos($m['caption'], '[isThumbnail]') !== false)
      {
        $output = m_url($m);
        break;
      }
    }
    if(empty($output))
      $output = m_url($media[0]);
  }
  elseif(count($media) == 1)
  {
    $output = m_url($media[0]);
  }
  return $output;
}

?>