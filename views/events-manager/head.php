<?
// events-manager
// path to config file
$config = $_SERVER['DOCUMENT_ROOT']."/open-records-generator/config/config.php";
require_once($config);

// specific to this 'app'
$config_dir = $root."/config/";

$user = $_SERVER['PHP_AUTH_USER'] ? $_SERVER['PHP_AUTH_USER'] : $_SERVER['REDIRECT_REMOTE_USER'];
$db = db_connect($user);

$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();
$rr = new Request();

$modified_uri = $uri;

if(end($modified_uri) == 'add' || end($modified_uri) == 'edit')
    unset($modified_uri[count($modified_uri) - 1]);
unset($modified_uri[1]);
unset($modified_uri[0]);
$modified_uri = array_values($modified_uri);
$id = end($oo->urls_to_ids($modified_uri));
if($id)
    $item = $oo->get($id);

$title = "Trigger | Events Manager";

?>
<!DOCTYPE html>
<html>
<head>
	<title><? echo $site_name ;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Sets whether a web application runs in full-screen mode. -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="trigger">
    <!-- Sets the style of the status bar for a web application. -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    
    <!-- <link rel="stylesheet" href="/static/style/mobile.css"> -->
    <script type = "text/javascript" src = "/static/js/var.js"></script>
    <script type = "text/javascript" src = "/static/js/function.js"></script>
    <!-- <link rel="stylesheet" href="https://use.typekit.net/odu6cjg.css"> -->
    <link rel="stylesheet" href="/static/style/events-manager.css">
</head>
<body>
<header>
    <?
        $nav_items = array();
        $nav_items[] = array(
            'name1' => 'Events Manager',
            'url'   => '/events-manager'
        );
        if(count($uri) > 2)
        {
            $this_item_name1 = ($uri[2] == 'upcoming') ? 'Upcoming' : 'Archive';
            $nav_items[] = array(
                'name1' => $this_item_name1,
                'url'   => '/events-manager/'.$uri[2]
            );
            if(count($uri) > 3)
            {
                if($uri[3] == 'add')
                {
                    $this_item_name1 = 'ADD';
                    $this_item_url = '#null';
                }
                else
                {
                    $this_item_name1 = prepareTitle($item['name1'])['title'];
                    $this_item_url = '/events-manager/'.$uri[2].'/'.$uri[3].'/edit';
                }
                if( strlen($this_item_name1) > 45 )
                {
                    $this_item_name1 = substr($this_item_name1, 0, 45) . '...';
                }
                $nav_items[] = array(
                    'name1' => $this_item_name1,
                    'url'   => $this_item_url
                );
                if(count($uri) > 4)
                {
                    $this_item_name1 = 'EDIT';
                    $this_item_url = '#null';
                    $nav_items[] = array(
                        'name1' => $this_item_name1,
                        'url'   => $this_item_url
                    );
                }
            }
        }

        ?><p class = "nav-item caption-roman" style = 'z-index: 10;'><?
        foreach($nav_items as $key => $item)
        {
            ?><a href = '<?= $item['url']; ?>'><?= $item['name1']; ?></a></p><p class = "nav-item caption-roman" style = 'z-index: <?= 9 - $key; ?>;'><?
        }
        ?></p><?
    ?>
</header>