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