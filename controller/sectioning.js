var sec_stack_h = 0;
var ticking = false;
var isSec_stack_hStable = false;
var topElement_bottom = 0;
var sectioning_title = function(topElement){
	var sTopElement = topElement;
	var sSection_title = document.getElementsByClassName("section_title");
	topElement_bottom = sTopElement.offsetTop+sTopElement.offsetHeight;
	var sSection_content = document.getElementsByClassName("section_content");
	if(getSectionTitle_h()){
		sec_stack_h = getSectionTitle_h();
		for(i = 0;i<sSection_title.length;i++){
			sSection_title[i].style.top = topElement_bottom + i*sec_stack_h+"px";
			sSection_title[i].setAttribute("scrollTo",sSection_content[i].id);
			sSection_title[i].setAttribute("scrollPadding",topElement_bottom+(i+1)*sec_stack_h);
			sSection_title[i].addEventListener("click",function(i){
			});
		}
		var sSubtitle = document.getElementsByClassName("subtitle");
		if(sSubtitle.length!=0){
			for(i = 0;i<sSubtitle.length;i++){
				sSubtitle[i].style.top = parseInt(sSubtitle[i].parentElement.parentElement.previousElementSibling.getAttribute("scrollPadding"))+(0.01*wW)+"px";
			}
		}
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

