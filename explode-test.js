var sExplodeCtner = document.getElementsByClassName('explode_ctner')[0];

var angle_num = 4;
var angle_r = 180 / angle_num;
var angle_r_base = 0;
var height_range = [0, 50];
var width_range = [0, 30];
var ec_h = sExplodeCtner.clientHeight;
var ec_w = sExplodeCtner.clientWidth;
var xmlns = 'http://www.w3.org/2000/svg';
var viewBox = '0 0 450 300';
var origin = [450, 300];
var point_x_dev_base = origin[0]/18;
var point_y_dev_base = origin[1]/18;

function gaussianRand() {
  var rand = 0;
  for (var i = 0; i < 6; i += 1) {
    rand += Math.random();
  }
  return rand / 6;
}
var svg = document.createElementNS(xmlns, 'svg');

svg.setAttributeNS(null, 'viewBox', viewBox);
svg.style.width = 450;
svg.style.height = 300;
svg.style.position = 'fixed';
svg.style.pointerEvents = 'none';
// sExplodeCtner.appendChild(svg);

// for( i = 0 ; i< angle_num ; i++){
// 	var pointsStr = '';
// 	var angle = document.createElementNS(xmlns, 'polygon');
// 	angle.className = 'angle';
// 	var thisW = parseInt(width_range[1] * gaussianRand());
// 	var thisH = parseInt(height_range[1] * gaussianRand());
// 	var thisD = parseInt(angle_r * gaussianRand());
// 	angle_r = (360 - thisD) / ( angle_num - (i + 1) );
// 	pointsStr += origin[0]-thisW/2+' '+origin[1]+' ';
// 	pointsStr += origin[0]+thisW/2+' '+origin[1]+' ';
// 	pointsStr += origin[0]+' '+(origin[1]+thisH);
// 	angle.setAttribute('points', pointsStr);
// 	angle.style.transform = 'rotate('+( angle_r + angle_r_base )+'deg)';
// 	svg.appendChild(angle);
// 	angle_r_base += angle_r;
// }
var duration = 250; //ms
var steps = 10;

var initial_points = '225.35 148.03 224.65 148.03 224 148.27 223.47 148.71 223.12 149.32 223 150 223.12 150.68 223.47 151.29 224 151.73 224.65 151.97 225.35 151.97 226 151.73 226.53 151.29 226.88 150.68 227 150 226.88 149.32 226.53 148.71 226 148.27 225.35 148.03';
var initial_points_axis_num = (initial_points.split(' ').length);
var final_points = '216 99 197 36 197 112 151 101 178.01 132.9 102 151 192 156 165 174 206 157 216.32 199.24 222 160 264 193 233 147 319 143 246 135 333 90 234 115 262 58 216 99';
var final_points_axis_num = (final_points.split(' ').length);
// var polygons = [];
var polygon = document.createElementNS(xmlns, 'polygon');
svg.appendChild(polygon);


initial_points = initial_points.split(' ');
final_points = final_points.split(' ');



function generatePoints(){
	var intermediate_points = [];
	intermediate_points.push(initial_points);
	currentIndex = 0;
	temp_initial = [];
	temp_final = [];
	temp_initial[currentIndex] = [];
	temp_final[currentIndex] = [];
	for(i = 0 ; i < initial_points_axis_num ; i++){
		if( i % 2 == 0 && i > 0){
			currentIndex ++;
			temp_initial[currentIndex] = [];
			temp_final[currentIndex] = [];
		}
		temp_initial[currentIndex].push(parseInt(initial_points[i]));
		temp_final[currentIndex].push(parseInt(final_points[i]));
	}

	for( i = 0 ; i < steps ; i++){
		intermediate_points[i] = [];
		for(j = 0; j < temp_initial.length ; j++){
			point_x_dev = point_x_dev_base * ( gaussianRand() * 2 - 1 );
			point_y_dev = point_y_dev_base * ( gaussianRand() * 2 - 1 );
			intermediate_points[i][j] = [];
			intermediate_points[i][j][0] = parseInt( temp_initial[j][0] + i * ( temp_final[j][0] - temp_initial[j][0] ) / (steps - 2) )+point_x_dev;
			intermediate_points[i][j][1] = parseInt( temp_initial[j][1] + i * ( temp_final[j][1] - temp_initial[j][1] ) / (steps - 2) )+point_y_dev;
			intermediate_points[i][j].join(',');
		}
	}

	for( i = 0 ; i < intermediate_points.length ; i ++){
		// console.log(intermediate_points[i]);
		if( i == 0){
			for(j = 0 ; j < intermediate_points[i].length ; j++)
				intermediate_points[i][j].join(',');
		}
		intermediate_points[i] = intermediate_points[i].join(' ');
	}
	return intermediate_points;
}

// console.log(intermediate_points);

// for( i = 0 ; i < final_points_num/3 ; i++ ){
// 	polygons[i] =  document.createElementNS(xmlns, 'polygon');
// 	polygons[i].setAttribute('fill', '#fff');
// 	svg.appendChild(polygons[i]);
// }

// function generateDots(dot_num, x_range, y_range){
// 	var points = [];
// 	var points_str = '';
// 	var current = 0;
// 	for( i = 0 ; i < (polygons.length+1)*3 ; i++ ){
// 		if(i % 3 == 0 && i > 0){
// 			console.log('pushinh when i = '+i);
// 			points.push(points_str);
// 			current++;
// 		}
// 		var thisX = parseInt( gaussianRand() * x_range );
// 		var thisY = parseInt( gaussianRand() * y_range );
// 		points_str += thisX+' '+thisY+' ';
// 	}
// 	return points;
// }
function setPoints(i, inter_points){
	setTimeout(function(){
		polygon.setAttribute('points', inter_points);
		console.log(i+'th of intermediate_points = '+inter_points);
	}, i * duration/steps);
	
}
sExplodeCtner.addEventListener('mouseenter', function(e){
	svg.style.left = e.clientX - parseInt( svg.style.width ) / 2;
	svg.style.top = e.clientY - parseInt( svg.style.height ) / 2;
	sExplodeCtner.appendChild(svg);
	var inter_points = generatePoints();
	for( i = 0 ; i < steps ; i++){
		setPoints(i, inter_points[i]);
	}
	setTimeout(function(){
		polygon.setAttribute('points', final_points);

	}, duration);
});








