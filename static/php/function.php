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
  $output = false;
  if(count($media) > 1)
  {
    foreach($media as $m)
    {
      $this_caption_raw = $m['caption'];
      $this_attr_end_pos = strpos($this_caption_raw, ']');
      if($this_attr_end_pos !== false)
      {
        $this_attr_length = $this_attr_end_pos - 1;
        $this_attr = substr($this_caption_raw, 1, $this_attr_length);
        if(strpos($this_attr, 'isThumbnail') !== false)
        {
          $output = m_url($m);
          break;
        }
      }
      else
        break;
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

function prepareTitle($str, $isEdit = false)
{
  if(!is_string($str))
    throw new Exception("[!] prepareTitle() received a non-string input.");
  $event_name1 = $str;
  $event_tag = 'Other';
  $tagdivider = '[tagdivider]';
  $tagdivider_pos = strpos($event_name1, $tagdivider);
  if($tagdivider_pos !== false){
    $event_tag = substr($event_name1, 0, $tagdivider_pos);
    if( strpos($event_tag, ',') !== false && !$isEdit){
      $event_tag_arr = explode(',', $event_tag);
      foreach($event_tag_arr as &$tag)
      {
        $tag = wysiwygClean($tag);
      }
      unset($tag);
    }
    else
      $event_tag_arr = array($event_tag);
    
    $event_name1 = substr($event_name1, $tagdivider_pos + strlen($tagdivider));
  }
  else
      $event_tag_arr = array($event_tag);
  $event_subtitle = '';
  $subtitledivider = '[subtitledivider]';
  $subtitledivider_pos = strpos($event_name1, $subtitledivider);
  if($subtitledivider_pos !== false){
    $event_subtitle = substr($event_name1, $subtitledivider_pos + strlen($subtitledivider));
    $event_name1 = substr($event_name1, 0, $subtitledivider_pos);
  }
  $event_title = $event_name1;

  return array('tag'=>$event_tag_arr, 'title'=>$event_title, 'subtitle'=>$event_subtitle);
}

function prepareBody($str)
{
  if(!is_string($str))
    throw new Exception("[!] prepareBody() received a non-string input.");

  $sectiondivider = '[sectiondivider]';
  $sectiontitledivider = '[sectiontitledivider]';
  $imagedivider = '[imagedivider]';
  $endimagedivider = '[endimagedivider]';
  $sectiondivider_pos = strpos($str, $sectiondivider);
  // var_dump($str);
  while($sectiondivider_pos !== false)
  {
    $this_section = substr( $str, 0, $sectiondivider_pos );
    $sectiontitledivider_pos = strpos($this_section, $sectiontitledivider);
    if($sectiontitledivider_pos !== false)
    {
      $temp = explode($sectiontitledivider, $this_section);
      $this_subtitle = $temp[0];
      $this_text = $temp[1];
    }
    else
    {
      $this_subtitle = '';
      $this_text = $this_section;
      
    }
    $imagedivider_pos = strpos($this_text, $imagedivider);
    if( $imagedivider_pos !== false )
    {
      $this_text = str_replace($imagedivider, '', $this_text);
      $this_text = str_replace($endimagedivider, '', $this_text);
    }
    $event_body[] = array(
      'sectiontitle' => $this_subtitle,
      'content' => wysiwygClean($this_text)
    );
    $str = substr($str, $sectiondivider_pos + strlen($sectiondivider) );
    $sectiondivider_pos = strpos($str, $sectiondivider);
  }
  if(!empty($str))
  {
    $sectiontitledivider_pos = strpos($str, $sectiontitledivider);
    if($sectiontitledivider_pos !== false)
    {
      $temp = explode($sectiontitledivider, $str);
      $this_subtitle = $temp[0];
      $this_text = $temp[1];
    }
    else
    {
      $this_subtitle = '';
      $this_text = $str;
    }
    $event_body[] = array(
      'sectiontitle' => $this_subtitle,
      'content' => $this_text
    );
  }
  

  return $event_body;
}

function prepareBody_edit($str)
{
  if(!is_string($str))
    throw new Exception("[!] prepareBody_edit() received a non-string input.");

  $sectiondivider = '[sectiondivider]';
  $sectiontitledivider = '[sectiontitledivider]';
  $imagedivider = '[imagedivider]';
  $endimagedivider = '[endimagedivider]';
  $sectiondivider_pos = strpos($str, $sectiondivider);

  while($sectiondivider_pos !== false)
  {
    $this_section = substr( $str, 0, $sectiondivider_pos );
    // var_dump($this_section);
    $sectiontitledivider_pos = strpos($this_section, $sectiontitledivider);
    if($sectiontitledivider_pos !== false)
    {
      $temp = explode($sectiontitledivider, $this_section);
      $this_subtitle = $temp[0];
      $this_content = $temp[1];
    }
    else
    {
      $this_subtitle = '';
      $this_content = $this_section;
    }


    $this_content_arr = array();
    $imagedivider_pos = strpos($this_content, $imagedivider);

    if($imagedivider_pos === false)
      $this_content_arr[] = array('content-type' => 'text', 'content' => wysiwygClean($this_content));
    else
    {
      while( $imagedivider_pos !== false ){
        $this_text = substr($this_content, 0, $imagedivider_pos);
        if(!wysiwygEmpty($this_text))
          $this_content_arr[] = array('content-type' => 'text', 'content' => wysiwygClean($this_text));
        $endimagedivider_pos = strpos($this_content, $endimagedivider);
        $image_str_length = $endimagedivider_pos - ($imagedivider_pos + strlen($imagedivider));
        $this_image = substr($this_content, $imagedivider_pos + strlen($imagedivider), $image_str_length);
        $this_content_arr[] = array('content-type' => 'image', 'content' => $this_image);
        $this_content = substr($this_content, $endimagedivider_pos + strlen($endimagedivider));
        $imagedivider_pos = strpos($this_content, $imagedivider);
      }
      if(!wysiwygEmpty($this_content))
      $this_content_arr[] = array('content-type' => 'text', 'content' => wysiwygClean($this_content));
    }
    $event_body[] = array(
      'sectiontitle' => $this_subtitle,
      'sectioncontent' => $this_content_arr
    );

    $str = substr($str, $sectiondivider_pos + strlen($sectiondivider) );
    $sectiondivider_pos = strpos($str, $sectiondivider);
  }

  if(!wysiwygEmpty($str))
  {
    $sectiontitledivider_pos = strpos($str, $sectiontitledivider);
    if($sectiontitledivider_pos !== false)
    {
      $temp = explode($sectiontitledivider, $str);
      
      $this_subtitle = $temp[0];
      $this_content = $temp[1];
    }
    else
    {
      $this_subtitle = '';
      $this_content = $str;
    }
    $this_content_arr = array();
    $imagedivider_pos = strpos($this_content, $imagedivider);

    if($imagedivider_pos === false)
      $this_content_arr[] = array('content-type' => 'text', 'content' => $this_content);
    else
    {
      while( $imagedivider_pos !== false ){
        $this_text = substr($this_content, 0, $imagedivider_pos);
        if(!empty($this_text))
          $this_content_arr[] = array('content-type' => 'text', 'content' => $this_text);
        $endimagedivider_pos = strpos($this_content, $endimagedivider);
        $this_image = substr($this_content, $imagedivider_pos + strlen($imagedivider), $endimagedivider_pos - strlen($endimagedivider));
        $this_content_arr[] = array('content-type' => 'image', 'content' => $this_image);
        $this_content = substr($this_content, $endimagedivider_pos + strlen($endimagedivider));
        $imagedivider_pos = strpos($this_content, $imagedivider);
      }
    }
    $event_body[] = array(
      'sectiontitle' => $this_subtitle,
      'sectioncontent' => $this_content_arr
    );
  }
  


  return $event_body;
}
function wysiwygEmpty($str)
{
  while(ord(substr($str, 0, 1)) == '9' || 
        ord(substr($str, 0, 1)) == '10' || 
        ord(substr($str, 0, 1)) == '13' || 
        ord(substr($str, 0, 1)) == '32')
  {
    $str = substr($str, 1);
  }
  // var_dump($str);
  if(empty($str))
    return true;
  return false;
}
function wysiwygClean($str)
{
  while(ord(substr($str, strlen($str) - 1)) == '9' || 
        ord(substr($str, strlen($str) - 1)) == '10' || 
        ord(substr($str, strlen($str) - 1)) == '13' || 
        ord(substr($str, 0, 1)) == '32'
       )
  {
    $str = substr($str, 1);
  }
  if(!empty($str))
  {
    while(ord(substr($str, strlen($str) - 1)) == '9' || 
          ord(substr($str, strlen($str) - 1)) == '10' || 
          ord(substr($str, strlen($str) - 1)) == '13' || 
          ord(substr($str, 0, 1)) == '32'
         )
    {
      $str = substr($str, 0, strlen($str) - 1);
    }
  }
  return $str;
}
function process_media_wysiwyg($toid)
{
  global $mm;
  global $rr;
  global $resize;
  global $resize_root;
  global $resize_scale;
  global $media_root;

  $m_rows = $mm->num_rows();
  $m_old = $m_rows;
  foreach($_FILES["uploads"]["error"] as $key => $error)
  {
    if($error == UPLOAD_ERR_OK)
    {
      $tmp_name = $_FILES["uploads"]["tmp_name"][$key];
      $m_name = $_FILES["uploads"]["name"][$key];
      $m_type = strtolower(end(explode(".", $m_name)));

      // add to db's image list
      $m_arr["type"] = "'".$m_type."'";
      $m_arr["object"] = "'".$toid."'";
      $m_arr["caption"] = "'".$rr->captions[$key+count($rr->medias)]."'";
      $insert_id = $mm->insert($m_arr);
      $m_rows++;

      $m_file = m_pad($insert_id).".".$m_type;
      $m_dest = $resize ? $resize_root : $media_root;
      $m_dest.= $m_file;

      if(move_uploaded_file($tmp_name, $m_dest)) {
        if($resize)
          resize($m_dest, $media_root.$m_file, $resize_scale);
      }
      else {
        $m_rows--;
        $mm->deactivate($insert_id);
      }
    }
  }
  return $m_old < $m_rows;
}
function getCleanCaption($str)
{
  $this_caption_raw = $str;
  $output = array();
  $isThumbnail = false;

  $this_caption_attr_end_pos = strpos($this_caption_raw, ']');
  if($this_caption_attr_end_pos !== false){
    $this_caption_attr_length = $this_caption_attr_end_pos - 1;
    $this_caption_attr = substr($this_caption_raw, 1, $this_caption_attr_length);
    $cleanedCaption = substr($this_caption_raw, $this_caption_attr_end_pos + 1);
    if( strpos($this_caption_attr, 'isThumbnail') !== false)
      $isThumbnail = true;
  }
  else
  {
    $this_caption_attr = '';
    $cleanedCaption = $this_caption_raw;

  }
  $output['isThumbnail'] = $isThumbnail;
  $output['cleanedCaption'] = $cleanedCaption;

  return $output;
}

?>