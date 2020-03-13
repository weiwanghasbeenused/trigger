var scrollEvents = function(child1 = null, child2 = null, child3 = null){
	window.addEventListener('scroll', function(){
		sTop = window.scrollY;
		if (!ticking) {
		    window.requestAnimationFrame(function() {
	    		child1(sTop);
	    		child2(sTop);
	    		child3(sTop);
		      	ticking = false;
		    });

		    ticking = true;
		}
	});
}
