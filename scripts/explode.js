var sExplodeCtner = document.getElementsByClassName('explodeCtner');
if(sExplodeCtner.length != 0){
	// animation
	var duration = 250; //ms
	var steps = 8;
	// svg
	var xmlns = 'http://www.w3.org/2000/svg';
	var viewBox = '0 0 450 300';
	var origin = [450, 300];
	var point_x_dev_base = origin[0]/18;
	var point_y_dev_base = origin[1]/18;
	// gaussian random
	function gaussianRand() {
	  var rand = 0;
	  for (var i = 0; i < 6; i += 1) {
	    rand += Math.random();
	  }
	  return rand / 6;
	}
	// random integer
	function getRandomInt(min, max) {
	    min = Math.ceil(min);
	    max = Math.floor(max);
	    return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	for(i = 0 ; i < sExplodeCtner.length ; i++){
		var thisSvg = sExplodeCtner[i].getElementsByClassName('explode')[0];
		thisSvg.setAttributeNS(null, 'viewBox', viewBox );
		if(sExplodeCtner[i].clientHeight < 50){
			thisSvg.style.width = '400%';
			thisSvg.style.height = '400%';
			thisSvg.style.top = '-150%';
			thisSvg.style.left = '-150%';
		}else if(sExplodeCtner[i].clientHeight < 150){
			thisSvg.style.width = '200%';
			thisSvg.style.height = '200%';
			thisSvg.style.top = '-50%';
			thisSvg.style.left = '-50%';
		}else{
			thisSvg.style.width = '150%';
			thisSvg.style.height = '150%';
			thisSvg.style.top = '-25%';
			thisSvg.style.left = '-25%';
		}

	}

	var initial_points = '225.35 148.03 224.65 148.03 224 148.27 223.47 148.71 223.12 149.32 223 150 223.12 150.68 223.47 151.29 224 151.73 224.65 151.97 225.35 151.97 226 151.73 226.53 151.29 226.88 150.68 227 150 226.88 149.32 226.53 148.71 226 148.27 225.35 148.03';
	var initial_points_axis_num = (initial_points.split(' ').length);
	var final_points_arr = [
		'236 78.66 200.11 3 199 88.66 103 3.66 174 111.66 27 89.66 153 148.66 28 202.66 177 180.66 149 291.66 219.14 183.81 311 250.66 247.69 165.83 379 201.66 278.35 135.17 444 68.66 255.09 107.68 312 41.66 236 78.66',
		'238 85 260 7 194 98 169 8 169 114 13 68 154.64 158.31 32 231 180.21 185.45 152 287 219.14 192.15 354 298 272 182 375 197 278.35 143.51 431 90 255.09 116.02 359 22 238 85',
		'222.31 87.47 200.11 11.34 183.19 99.1 42.56 11.34 151.47 119.19 48.91 154.09 154.64 158.31 69 242.9 180.21 185.45 183.19 300 219.14 192.15 260.38 246.07 247.69 174.18 427.44 247.13 278.35 143.51 390.43 104.39 255.09 116.02 329.1 5 222.31 87.47',
		'217.47 88.22 164.38 18.53 177.65 107.02 32.75 111.44 152.36 138.71 63.72 183.34 161.06 168.96 32.75 284 183.18 186.66 205.3 243.07 217.47 184.45 312 250.29 254.44 164.89 387.81 186.66 278.58 142.61 413.25 36.23 256.3 105.47 286.05 13 217.47 88.22',
		'222.48 105.75 190.59 0 186 119 83 77 165 158 15 199 171 186 116 247 201 193 223.01 274 238 210 325 291 251.02 186.31 395.37 179.6 272.84 166.17 418.87 90.64 252.69 132.6 299.69 36.93 222.48 105.75'
	];
	// var final_points = '222.48 105.75 190.59 0 190.59 127.57 113.38 109.1 158.72 162.65 31.13 193.03 182.2 201.42 136.88 231.63 205.7 203.1 223.01 274 232.55 208.13 303.05 263.52 251.02 186.31 395.37 179.6 272.84 166.17 418.87 90.64 252.69 132.6 299.69 36.93 222.48 105.75';
	var polygon = document.createElementNS(xmlns, 'polygon');
	polygon.setAttribute('fill', '#fff');

	initial_points = initial_points.split(' ');

	function generatePoints(final_points){
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

	function setPoints(i, inter_points){
		setTimeout(function(){
			polygon.setAttribute('points', inter_points);
		}, i * duration/steps);
		
	}
	Array.prototype.forEach.call(sExplodeCtner, function(el, j){
		sExplodeCtner[j].addEventListener('mouseenter', function(e){
			var k = getRandomInt(0, final_points_arr.length-1);
			var final_points = final_points_arr[k].split(' ');
			var thisSvg = sExplodeCtner[j].getElementsByClassName('explode')[0];
			thisSvg.appendChild(polygon);
			var inter_points = generatePoints(final_points);
			for( i = 0 ; i < steps ; i++){
				setPoints(i, inter_points[i]);
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
}