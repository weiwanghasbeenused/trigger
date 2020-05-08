var sec_stack_h = 0;
var ticking = false;
var isSec_stack_hStable = false;
var topElement_bottom = 0;
var sectioning_title = function(topElement){
	var sTopElement = topElement;
	var sSection_title = document.getElementsByClassName("section_title");
	topElement_bottom = sTopElement.offsetTop+sTopElement.offsetHeight;
	var sSection_content = document.getElementsByClassName("section_content");
	if(sSection_title.length != 0)
		sSection_title[0].style.top = topElement_bottom+"px";

	if(sSection_title.length > 1){
		Array.prototype.forEach.call(sSection_title, function(el, i){
			if(i > 0){
				sSection_title[i].style.top = sSection_title[i-1].style.top + sSection_title[i-1].clientHeight;
			}
		});
	}
	
}

function getSectionTitle_h(){
	sSection_title = document.getElementsByClassName("section_title");
	if(sSection_title.length > 1){
		var sec_stack_h = sSection_title[1].offsetHeight;
	}else{
		sec_stack_h = false;
	}
	return sec_stack_h;
}

var scrollEvents = function(){
	window.addEventListener('scroll', function(){
		if(!isSec_stack_hStable && getSectionTitle_h()){
			if (!ticking) {
			    window.requestAnimationFrame(function() {
		    		var sectionTitle_h = getSectionTitle_h();
		    		if(sectionTitle_h == sec_stack_h)
		    			isSec_stack_hStable = true;
		    		else{
		    			sec_stack_h = sectionTitle_h;
		    			var sSection_title = document.getElementsByClassName("section_title");
		    			for(i = 0;i<sSection_title.length;i++){

							sSection_title[i].style.top = topElement_bottom + i*sec_stack_h+"px";
							sSection_title[i].setAttribute("scrollTo",sSection_content[i].id);
							sSection_title[i].setAttribute("scrollPadding",topElement_bottom+(i+1)*sec_stack_h);
						}
		    		}
			      	ticking = false;
			    });

			    ticking = true;
			}
		}
	});
}

