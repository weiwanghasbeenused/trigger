var scrollEvents = function(child1){
	window.addEventListener('scroll', function(){
		sTop = window.scrollY;
		if (!ticking) {
		    window.requestAnimationFrame(function() {
	    		child1(sTop);
		      	ticking = false;
		    });

		    ticking = true;
		}
	});
}
