var wW = window.innerWidth,
	wH = window.innerHeight;

var status_isMobile = false;
if(wW < 720){
	status_isMobile = true;
}
// scroll
var ticking = false;
var sTop = window.scrollY;