<?
$this_id = $item['id'];
$isSearch = false;
$noResult = false;
if(isset($_POST['keyword']) && $_POST['keyword'] != ''){
	$isSearch = true;
	$keyword = $_POST['keyword'];
	$children = search($this_id, $keyword);
	if(count($children) == 0)
		$noResult = true;
}else{
	$children = $oo->children($this_id);
}

$index_list = array();
foreach($children as $key => $child){
	$index_list[$key]['name'] = $child['name1'];
	$index_list[$key]['link'] = $child['website'];
	$index_list[$key]['exhibit'] = $child['exhibit'];
	$index_list[$key]['brief'] = $child['main_one'];
	$index_list[$key]['tag'] = $child['main_two'];
}
require_once('views/artist-index.php');
?>
<script>
	var sExplodeCtner = document.getElementsByClassName('explodeCtner');
	if(!status_isMobile){
		// svg
		var xmlns = 'http://www.w3.org/2000/svg';
		var viewBox = '0 0 450 300';
		var origin = [450, 300];
		var point_x_dev_base = origin[0]/10;
		var point_y_dev_base = origin[1]/10;

		var polygon = document.createElementNS(xmlns, 'polygon');
		polygon.setAttribute('fill', '#fff');

		// initial_points = initial_points.split(' ');
	}

	var sArtist_index_item = document.getElementsByClassName('artist-index_item');
	Array.prototype.forEach.call(sArtist_index_item, function(el, i){
		var this_btn = el.getElementsByClassName('item_name')[0];
		var this_a = el.getElementsByTagName('a');
		el.addEventListener('click', function(e){
			if(outsideClick(e, this_a)){
				if(el.classList.contains('expanded')){
					if(!status_isMobile){
						var thisSvg = el.querySelector('svg');
						thisSvg.removeChild(polygon);
					}

					el.classList.toggle('expanded');
				}else{
					var otherExpanded = document.querySelector('.artist-index_item.expanded');
					if(otherExpanded != null){
						otherExpanded.classList.remove('expanded');
						setSvgSize(otherExpanded);
					}
					el.classList.toggle('expanded');
					if(!status_isMobile){
						var thisSvg = el.querySelector('svg');
						var k = getRandomInt(0, final_points_arr.length-1);
						var final_points = final_points_arr[k].split(' ');
						var inter_points = generatePoints(initial_points, final_points);
						thisSvg.appendChild(polygon);
						setSvgSize(el);
						for( i = 0 ; i < steps ; i++){
							setPoints(i, inter_points[i], polygon);
						}
						setTimeout(function(){
							polygon.setAttribute('points', final_points);
						}, duration);
					}
				}
				
			}
		});
	});

</script>