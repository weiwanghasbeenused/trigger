
// if click outside an element
function outsideClick(event, notelem)	{
    var clickedOut = true, 
    	i, 
    	len = notelem.length;
    if(typeof len == 'undefined'){
		if (event.target == notelem || notelem.contains(event.target)) {
            clickedOut = false;
        }
    }else{
    	for (i = 0;i < len;i++)  {
	        if (event.target == notelem[i] || notelem[i].contains(event.target)) {
	            clickedOut = false;
	        }
	    }
    }
    if (clickedOut) 
    	return true;
    else 
    	return false;
}

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

// explosion
function generatePoints(initial_points, final_points){
	var intermediate_points = [];
	intermediate_points.push(initial_points);
	var currentIndex = 0;
	var temp_initial = [];
	var temp_final = [];
	temp_initial[currentIndex] = [];
	temp_final[currentIndex] = [];
	var initial_points_axis_num = (initial_points.length);
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

function setPoints(i, inter_points, polygon){
	setTimeout(function(){
		polygon.setAttribute('points', inter_points);
	}, i * duration/steps);
}

function setSvgSize(thisExplodeCtner){
	var thisSvg = thisExplodeCtner.getElementsByClassName('explode')[0];
	thisSvg.setAttributeNS(null, 'viewBox', viewBox );
	if(thisExplodeCtner.classList.contains('event_arch') || ( thisExplodeCtner.classList.contains('artist-index_item') && !thisExplodeCtner.classList.contains('expanded')) ){
		thisSvg.style.width = '20vw';
		thisSvg.style.height = '20vw';
		thisSvg.style.top = '-8vw';
		thisSvg.style.left = '-7vw';
	}else if(thisExplodeCtner.clientHeight < 50){
		thisSvg.style.width = '400%';
		thisSvg.style.height = '400%';
		thisSvg.style.top = '-150%';
		thisSvg.style.left = '-150%';
	}else if(thisExplodeCtner.clientHeight < 150){
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

