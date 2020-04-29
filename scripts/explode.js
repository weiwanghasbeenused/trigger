var sExplodeCtner = document.getElementsByClassName('explodeCtner');
if(!status_isMobile){
	// svg
	var xmlns = 'http://www.w3.org/2000/svg';
	var viewBox = '0 0 450 300';
	var origin = [450, 300];
	var point_x_dev_base = origin[0]/10;
	var point_y_dev_base = origin[1]/10;

	for(i = 0 ; i < sExplodeCtner.length ; i++){
		setSvgSize(sExplodeCtner[i]);
	}

	var polygon = document.createElementNS(xmlns, 'polygon');
	polygon.setAttribute('fill', '#fff');

	initial_points = initial_points.split(' ');

	Array.prototype.forEach.call(sExplodeCtner, function(el, j){
		sExplodeCtner[j].addEventListener('mouseenter', function(e){
			var k = getRandomInt(0, final_points_arr.length-1);
			var final_points = final_points_arr[k].split(' ');
			var thisSvg = sExplodeCtner[j].getElementsByClassName('explode')[0];
			thisSvg.appendChild(polygon);
			var inter_points = generatePoints(initial_points, final_points);
			for( i = 0 ; i < steps ; i++){
				setPoints(i, inter_points[i], polygon);
			}
			setTimeout(function(){
				polygon.setAttribute('points', final_points);
			}, duration);
		});
		sExplodeCtner[j].addEventListener('mouseleave', function(e){
			var thisSvg = sExplodeCtner[j].getElementsByClassName('explode')[0];
			thisSvg.removeChild(polygon);
		});
	});
	var logo_explodeCtner = document.getElementsByClassName('logo_explodeCtner')[0];

	var logo_initial_points = '90 154 89 153 88 152 87 151 85 151 83 153 82 155 82 156 82 157 82 158 82 159 82 160 83 161 84 161 85 161 86 161 87 161 88 160 89 159 90 158 90 157 90 156 90 154';
	var logo_final_points = '121.5 140.5 200 70 105.24 129.71 147.81 0 86.5 116.5 78.5 43.5 74.18 131.45 14.5 58.5 58.5 148.5 2.5 144.5 54.5 169.5 0 220.14 55.93 187.49 8.8 300 75.5 206.5 83.5 260.5 92.5 195.5 179.5 278.5 114.5 183.5 157.5 195.5 118.5 162.5 183.07 140.92 121.5 140.5';
	logo_initial_points = logo_initial_points.split(' ');
	logo_final_points = logo_final_points.split(' ');
	var logo_polygon = logo_explodeCtner.getElementsByTagName('polygon')[0];
	logo_explodeCtner.addEventListener('mouseenter', function(){
		var inter_points = generatePoints(logo_initial_points, logo_final_points);
		for(i = 0; i< steps; i++){
			setPoints(i, inter_points[i], logo_polygon);
		}
		setTimeout(function(){
			logo_polygon.setAttribute('points', logo_final_points);
		}, duration);

	});
}

