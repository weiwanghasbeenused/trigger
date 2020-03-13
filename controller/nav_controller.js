

var sNav = document.getElementById("nav");
var navIsFolded = false;
var boundary_nav = 0.1*wH;

function foldNav(scroll_y){
	if(scroll_y >= boundary_nav && !navIsFolded){
	  	navIsFolded = !navIsFolded;
	  	sNav.classList.add("folded");
	}else if(scroll_y < boundary_nav && navIsFolded){
	  	sNav.classList.remove("folded");
	  	navIsFolded = !navIsFolded;
	}
}

