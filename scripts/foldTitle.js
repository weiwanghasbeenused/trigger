

var sTitle_title = document.getElementById("title_title");
var titleIsFolded = false;
var boundary_title = 0.1*wH;

function foldTitle(scroll_y, range_dev = 0){
	if(scroll_y >= boundary_title && !titleIsFolded){
	  	titleIsFolded = !titleIsFolded;
	  	sTitle_title.classList.add("folded");
	}else if(scroll_y < 1 && titleIsFolded){
	  	sTitle_title.classList.remove("folded");
	  	titleIsFolded = !titleIsFolded;
	}
}

