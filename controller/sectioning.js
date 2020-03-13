var sectioning_title = function(topElement){
	// window).scrollTop(0);
	var sTopElement = topElement,
		sSection_title = document.getElementsByClassName("section_title"),
		topElement_bottom = sTopElement.offsetTop+sTopElement.offsetHeight,
		sSection_content = document.getElementsByClassName("section_content"),
		sec_stack_h = 0;
		console.log("sTopElement = "+sTopElement);
	if(sSection_title.length > 1){
		var sec_stack_h = sSection_title[1].offsetHeight;
	}
	for(i = 0;i<sSection_title.length;i++){

		sSection_title[i].style.top = topElement_bottom + i*sec_stack_h+"px";
		sSection_title[i].setAttribute("scrollTo",sSection_content[i].id);
		sSection_title[i].setAttribute("scrollPadding",topElement_bottom+(i+1)*sec_stack_h);
		sSection_title[i].addEventListener("click",function(i){
			// EPPZScrollTo.scrollVerticalToElementById(this.getAttribute("scrollTo"), this.getAttribute("scrollPadding"));
		});
	}

	var sSubtitle = document.getElementsByClassName("subtitle");
	if(sSubtitle.length!=0){
		for(i = 0;i<sSubtitle.length;i++){
			sSubtitle[i].style.top = parseInt(sSubtitle[i].parentElement.parentElement.previousElementSibling.getAttribute("scrollPadding"))+(0.01*wW)+"px";
		}
	}


}

