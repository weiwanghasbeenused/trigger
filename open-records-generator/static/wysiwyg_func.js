var wW = window.innerWidth,
	wH = window.innerHeight;

var status_device = 0,
	boundary_device = 850;
if(wW<850){
	status_device = 1;
}
var unDo = [];
var unDoSteps = -1;

// ==============================================================
// From o-r-g, with some btns removed


// ==============================================================
function sethtml(name) {
	console.log("sethtml");
	var sToolbar = document.getElementById(name + '-toolbar');
	var editable = document.getElementById(name + '-editable');
	var textarea = document.getElementById(name + '-textarea');
	sToolbar.classList.toggle('reverse');
	textarea.classList.toggle('hidden');
	editable.classList.toggle('hidden');

	var passString = editable.innerHTML;
	textarea.value = passString;

}

function showrich(name) {
	var bold = document.getElementById(name + '-bold');
	var italic = document.getElementById(name + '-italic');
	var link = document.getElementById(name + '-link');
	var sToolbar = document.getElementById(name + '-toolbar');
	var editable = document.getElementById(name + '-editable');
	var textarea = document.getElementById(name + '-textarea');
	sToolbar.classList.toggle('reverse');
	textarea.classList.toggle('hidden');
	editable.classList.toggle('hidden');

	var passString = textarea.value;
	editable.innerHTML = passString;
}


function pretty(str) {
	// Format the string to be wrapped only in p.body:
	// if the str has been prettified or not;
	// var beenPrettied = str.indexOf('p class="body"');
	var beenPrettied = true;
	var firstDivIndex = str.indexOf("<div");
	// Sometimes the first paragraph will be wrapped nothing
	if(firstDivIndex != 0){
		var preFirstDiv = str.slice(0, firstDivIndex);
		var postFirstDiv = str.slice(firstDivIndex);
		str = '<div>'+preFirstDiv+'</div>'+	postFirstDiv;
	}

	// str = str.replace(/<div>/gi,'<p class="body">');
	// str = str.replace(/<\/div>/gi,"</p>");
	
	var isBrFree = str.indexOf("<br");
	if (isBrFree !== -1){
		str = str.replace(/<br\s*[\/]?>/gi,'<\/div><div>');
	}
	str = str.replace(/<div><\/div>/gi,'');  
	 
	return str; 
}

function stripEmptyTags(name){
	// remove all the empty elements
	// which result from addTag() (or other causes);
	var editor = document.getElementById(name+"-editable");
	var allDescendant = document.querySelectorAll("#"+name+"-editable *");
	var length = allDescendant.length;
	for(i = 0; i<length;i++){
		var thisContent = allDescendant[i].innerHTML;
		var thisTagName = allDescendant[i].tagName;
		if(!thisContent || thisContent=="" || thisContent==" "||thisContent =="&nbsp;" ){
			if(thisTagName != 'IMG'){
				var thisParent = allDescendant[i].parentNode;
				thisParent.removeChild(allDescendant[i]);
			}else{
				console.log("found img");
			}
		}
	}
}

function rmSpan(name){
	var span = document.querySelectorAll('#'+name+'-editable span');
	// while(span.length) {
	//     var parent = span[ 0 ].parentNode;
	    
	//     while( span[ 0 ].firstChild ) {
	//         parent.insertBefore(  span[ 0 ].firstChild, span[ 0 ] );
	//     }
	//     parent.removeChild( span[ 0 ] );
	//     span = document.querySelectorAll('#'+name+'-editable span');
	//     console.log(span.length);
	// }
	for(i = 0 ; i < span.length ; i++){
		var parent = span[i].parentNode;
		while( span[ i ].firstChild ) {
	        parent.insertBefore(  span[ i ].firstChild, span[ i ] );
	    }
	    parent.removeChild( span[ i ] );
	}
}
function rmP(name){
	var p = document.querySelectorAll('#'+name+'-editable p');
	// while(p.length) {
	//     var parent = p[ 0 ].parentNode;
	//     var br = document.createElement('<br>');
	//     while( p[ 0 ].firstChild ) {
	//         parent.insertBefore(  p[ 0 ].firstChild, p[ 0 ] );
	//         parent.insertBefore(  br, p[ 0 ] );
	//     }
	//     parent.removeChild( p[ 0 ] );
	// }
	console.log(p);
	for(i = 0 ; i < p.length ; i++){
		var parent = p[i].parentNode;
		var br = document.createElement('br');
		console.log(i);
		while( p[ i ].firstChild ) {
	        parent.insertBefore(  p[ i ].firstChild, p[ i ] );
	    }
	    parent.insertBefore(  br, p[ i ] );
	    parent.removeChild( p[ i ] );
	}
}
var stripTags = function(str, brFree = false){
	var temp_element = document.createElement("div");
	temp_element.setAttribute('contenteditable', true);
	temp_element.innerHTML = str;
	if(!brFree){
		var exceptionStr = "imABreakTagReplaceMeSenpai";
		var exceptionRegexp = /imABreakTagReplaceMeSenpai/gi;
		temp_element.innerHTML = str.replace(/<br\s*[\/]?>/gi, exceptionStr);
    	temp_element.innerHTML = temp_element.innerHTML.replace(/(<([^>]+)>)/ig,"");
	    temp_element.innerHTML = temp_element.textContent.replace(exceptionRegexp, "<br>");
	}else{
    	temp_element.innerHTML = temp_element.innerHTML.replace(/(<([^>]+)>)/ig,"");
	}
	temp_element.innerHTML = temp_element.innerHTML.replace(/&nbsp;/g,'');
	return temp_element.innerHTML;
}
var stripNbsp = function(str){
	return str.replace(/&nbsp;/g,'');
}


var selText = "";
var rr;
var selRange = [];
var selected_el = null;
var selectedParentNodeOrder = -1;
var selectedGrandParentNodeOrder = -1;
var selParentIndex = [];
var selChildIndex = [];

function setSelection(){
	var sel;
	if(typeof window.getSelection !== "undifined"){
		if(window.getSelection().type == 'None'){
			console.log("window gets selection but type == None");
			return false;
		}else{
			sel = window.getSelection();
		}
	}else if(typeof document.selection !== "undifined"){
		sel = document.selection;
	}else{
		console.log("can't get active text");
		return false;
	}
	
	selText = sel.toString();
	
	// var temp_element = document.createElement("span");
	// temp_element.innerHTML = selText;
	// selText = stripNbsp(temp_element.innerHTML);
	rr = sel.getRangeAt(0);	
	selected_el = rr.startContainer;
	while(selected_el.nodeType == 3){
		selected_el = selected_el.parentElement;
	}
	selRange[0] = rr.startOffset;
	selRange[1] = rr.endOffset;
	// if(selRange[0] == 0 && selRange[1] == 0 && selText.length > 0){
	// 	// if the text includes line break at the end;
	// 	selText = selText.substring(0, selText.length - 2);
	// 	selRange[1] = selText.length;
	// }
	
	// var rr_ancestor = [];
	// var generation_el = selected_el,
	// 	generation_el_id = generation_el.id,
	// 	generation_count = 0;
	// while(generation_el_id != origin_id){
	// 	rr_ancestor[generation_count] = document.createRange();
	// 	rr_ancestor[generation_count].selectNode(generation_el);
	// 	selParentIndex[generation_count] = rr_ancestor[generation_count].startOffset;
	// 	generation_el_id = rr_ancestor[generation_count].startContainer.id;
	// 	generation_el = generation_el.parentElement;
	// 	generation_count++;
	// }
	// for (i = 0;i<selParentIndex.length;i++){
	// 	var order_reversed = selParentIndex.length-i-1;
	// 	selChildIndex[order_reversed] = selParentIndex[i];
	// }
}
var addListeners_selection = function(name){
	var editable = document.getElementById(name+"-editable");
	editable.addEventListener('mouseup', function(){
		setSelection(name);
	});
	editable.addEventListener('keyup', function(event){
		// if right arrow or left arrow;
		if (event.keyCode === 37 || event.keyCode === 38 || event.keyCode === 39 || event.keyCode === 40) {
		   setSelection(name);
		}else if(event.keyCode === 13){
			// var content_section = document.querySelectorAll('#'+name+'-editable .content_section');
		}

	});
}
var addTag2 = function(name, tagName, newclass, imgUrl = null, imgCaption = null){
	if(selected_el && fullHTML.indexOf(selText)!= -1 ){
		editingCommit(name);
		var caretTarget = document.getElementById("caretTarget");
		if (caretTarget !== null){
			caretTarget.parentNode.removeChild(caretTarget);
		}
		var editor = document.getElementById(name+"-editable");
		var textarea = document.getElementById(name + '-textarea');
		var fullHTML = selected_el.innerHTML,
			fullText = selected_el.innerText;
		var tagName = tagName;
		var tempText = [];

		tempText[0] = fullHTML.slice(0, selRange[0]);
		tempText[1] = fullHTML.slice(selRange[0], selRange[1]);
		tempText[2] = fullHTML.slice(selRange[1], fullHTML.length);
		if(tempText[2] == '<br>' || tempText[2] == '&nbsp;'){
			tempText[2] = '';
		}
		



		if(newclass == 'subtitle'){
			tempText[0] += '</div></div><div class="content_section">';
			tempText[2] = '<div>'+tempText[2];
			tempText[1] = '<'+tagName+" class = '"+newclass+"'>"+tempText[1]+"</"+tagName+">";
		}else if(newclass == 'qandaname'){
			tempText[1] = '<'+tagName+" class = '"+newclass+"'>"+tempText[1]+"</"+tagName+">";
		}else if(newclass == 'img_ctner_temp'){
			tempText[0] += '</div>';
			tempText[2] = '<div>'+tempText[2];
			tempText[1] = '<'+tagName+" class = '"+newclass+"' src = '"+imgUrl+"' caption = '"+imgCaption+"'>";
		}else{
			return false;
		}

		var modifiedContent = tempText[0] + tempText[1] +"<span id = 'caretTarget'>1</span>"+ tempText[2];
		editor.innerHTML = replaceSelected(name, modifiedContent);
		setCaretPosition();
		selText = "";
		selRange = [];
		selected_el = null;
		selParentIndex = [];
		selChildIndex = [];
		stripEmptyTags(name);
		editingCommit(name);

	}else{
		console.log("this text can not be modified");
	}
}

function addTag(name, tagName, newclass, imgUrl = null, imgCaption = null){
	editingCommit(name);
	setSelection();
	const oldConent = document.createTextNode(rr.toString());
	const newElement = document.createElement(tagName);
	newElement.className = newclass;
	newElement.append(oldConent);
	if(tagName == "span"){
		// for inline elements
		rr.deleteContents();
		rr.insertNode(newElement);
	}else if(newclass == "img_ctner"){
		var blankChars = [10, 32, 160];
		var fullText = selected_el.innerText;
		var lastCode_fullText = fullText.charCodeAt(selText.length-1);
		while(blankChars.indexOf(lastCode_fullText) != -1 || isNaN(lastCode_fullText)){
			if(fullText.length > 1){
				fullText = fullText.substring(0, fullText.length-1);
				lastCode_fullText = fullText.charCodeAt(fullText.length-1);
			}else{
				console.log("only one char in fullText");
				fullText = false;
				break;
			}
		}
		if(!fullText || fullText == "undefined"){
			console.log("an empty line");
			var newImg = document.createElement('img');
			newImg.src = imgUrl;
			var newCaption = document.createElement('figcaption');
			newCaption.innerText = imgCaption;
			newElement.appendChild(newImg);
			newElement.appendChild(newCaption);
			selected_el.parentNode.replaceChild(newElement, selected_el);
		}else{
			alert('please insert the image at an empty line.');
		}
	}else{
		// for blocks
		var temp = document.createElement(tagName);
		temp.innerText = selText;
		if(temp.innerText == selected_el.innerText){
			temp.className = newclass;
			selected_el.parentElement.replaceChild(temp, selected_el);

		}else{
			alert('please select an [isolated paragraph].');
		}
	}
}

function htmlToText(el){
	var temp_element1 = document.createElement("div");
	var temp_element2 = el.cloneNode(true);
	temp_element1.append(temp_element2);
	return temp_element1.innerHTML;
}

function getSelected_el(){
    if (document.selection)
        return document.selection.createRange().parentElement();
    else
    {
        var selection = window.getSelection();
        if (selection.rangeCount > 0)
            return selection.getRangeAt(0).startContainer.parentElement;
    }
}


var addListeners_paste = function(name){
	var editable = document.getElementById(name+'-editable');

	editable.addEventListener("paste", function(e) {
	    setTimeout(function(){
	    	var temp = document.createElement('div');
	    	temp.setAttribute('id', 'temp');
	    	temp.innerHTML = editable.innerHTML;
	    	var span_temp = temp.querySelectorAll('span');
	    	// var p_temp = temp.getElementsByTagName('p');
	    	console.log(name);
	    	rmSpan(name);
	    	rmP(name);
	    	// editable.innerHTML = temp.innerHTML;
			// editingCommit(name);
		}, 0);
	});




		// editable.addEventListener('paste', (event) => {
		// editingCommit(name);
		// var paste_content = (event.clipboardData || window.clipboardData).getData('text/html');
		// var temp_element = document.createElement("div");
		//     temp_element.setAttribute('contenteditable', true);
		// var isEmpty = false;
		// if(stripTags(editable.innerHTML, true) == ""){
		// 	isEmpty = true;
		// };
		// var caretTarget = document.getElementById("caretTarget");
		// console.log("caretTarget = "+caretTarget);
		// if (caretTarget !== null){
		// 	caretTarget.parentNode.removeChild(caretTarget);
		// }
		// if(isEmpty){

		// 	editable.innerHTML = "";
		//     if(!paste_content){
		//     	var paste_content = (event.clipboardData || window.clipboardData).getData('text/plain');
		// 	}
		//     temp_element.innerHTML = stripTags(paste_content);
		//     editable.innerHTML = '<div class = "content_section">'+pretty(temp_element.innerHTML)+'<span id = "caretTarget">1</span></div>';
		//     setCaretPosition();
		//     setTimeout(function(){
		//     	rmSpan(name);
		//     	stripEmptyTags(name);
		//     },0);


		//     event.preventDefault();
		// }else{
		// 	if(paste_content){
		// 		event.preventDefault();
		// 	    temp_element.innerHTML = stripNbsp(stripTags(paste_content));
		// 	    var fullHTML = selected_el.innerHTML;
		// 	    var tempText = [];
		// 	    tempText[0] = fullHTML.substring(0, selRange[0]);
		// 	    tempText[1] = temp_element.innerHTML;
		// 	    tempText[2] = fullHTML.substring(selRange[0]);
		// 	    var modifiedContent = tempText[0]+tempText[1]+'<span id = "caretTarget">1</span>'+tempText[2];
			    
		// 	    editable.innerHTML = pretty(replaceSelected(name, modifiedContent));
		// 	    setCaretPosition();
		// 	    setTimeout(function(){
		// 			rmSpan(name);
		// 	    	stripEmptyTags(name);
		// 	    },0);
		//     }else{
		//     	var paste_content = (event.clipboardData || window.clipboardData).getData('text/plain');
		//     	editable.innerHTML = pretty(editable.innerHTML);
		//     	setCaretPosition();
		//     	setTimeout(function(){
		//     		rmSpan(name);
		//     		stripEmptyTags(name);
		//     	}, 0);
		//     }
		// }
	// 	setTimeout(function(){
	// 		editingCommit(name);
	// 	}, 0);
	// });
}

  
var editingCommit = function(name){
	for(i = 0; i< unDoSteps ; i++){
		unDo.shift();
	}
	unDoSteps = 0;
    saveHTML(name);
}

var saveHTML = function(name){
	var editor = document.getElementById(name+"-editable");
	var newEdition = editor.innerHTML;
	unDo.unshift(newEdition);
	if(unDo.length > 300){
		unDo.pop();
	}
}
var undo = function(name){
	if(unDoSteps<unDo.length){
		var editor = document.getElementById(name+"-editable");
		if(unDoSteps == 0 && unDo[0] !== editor.innerHTML){
			saveHTML(name);
		}
		unDoSteps++;
		editor.innerHTML = unDo[unDoSteps];
	}else{
		alert("Reached the earliest record!");
	}
	
}
var redo = function(name){
	if(unDoSteps>0){
		var editor = document.getElementById(name+"-editable");
		unDoSteps--;
		editor.innerHTML = unDo[unDoSteps];
	}else{
		alert("Reached the latest record!");
	}
}
function setCaretPosition(elm = document.getElementById('caretTarget'), pos = 0) {
 	 var tag = elm; 

	// Creates range object 
	var setpos = document.createRange(); 
	  
	// Creates object for selection 
	var set = window.getSelection(); 
	// Set start position of range 
	setpos.setStart(tag.childNodes[0], pos); 
	
	// Collapse range within its boundary points 
	// Returns boolean 
	setpos.collapse(true); 
	  
	// Remove all ranges set 
	set.removeAllRanges(); 
	  
	// Add range with respect to range object. 
	
	set.addRange(setpos); 
	  
	// Set cursor on focus 
	tag.focus(); 
	tag.parentNode.removeChild(tag);
}

function wrappingImgCtner(name){
	var editor = document.getElementById(name+"-editable");
	var query = "#"+name+"-editable img.img_ctner_temp";
	var allImgCtner = document.querySelectorAll(query);
	if(allImgCtner.length > 0){
		for(i = 0; i <allImgCtner.length;i++){
			var thisImgCtner = allImgCtner[i];
			allImgCtner[i].parentNode.replaceChild(tempToImgCtner(allImgCtner[i]), allImgCtner[i]);
		}

	}else{
		return false;
	}
}
function unWrappingTemp(name){
	var editor = document.getElementById(name+"-editable");
	var query = "#"+name+"-editable div.img_ctner";
	var allImgCtner = document.querySelectorAll(query);
	if(allImgCtner.length > 0){
		for(i = 0; i <allImgCtner.length;i++){
			var thisImgCtner = allImgCtner[i];
			allImgCtner[i].parentNode.replaceChild(imgCtnerToTemp(allImgCtner[i]), allImgCtner[i]);
		}

	}else{
		return false;
	}
}
function tempToImgCtner(obj){
	var oldImgCtner = obj;
	var newImgCtner = document.createElement("div");
	newImgCtner.className = 'img_ctner';
	var newImgCtner_img = document.createElement("img");
	newImgCtner_img.src = oldImgCtner.src;
	var newImgCtner_caption = document.createElement("p");
	newImgCtner_caption.className = 'caption';
	newImgCtner_caption.innerText = oldImgCtner.getAttribute('caption');
	newImgCtner.appendChild(newImgCtner_img);
	newImgCtner.appendChild(newImgCtner_caption);
	return newImgCtner;
}
function imgCtnerToTemp(obj){
	var oldImgCtner = obj;
	var newImgCtner_img = document.createElement("img");
	newImgCtner_img.src = oldImgCtner.childNodes[0].src;
	newImgCtner_img.setAttribute('caption', oldImgCtner.childNodes[1].innerText);
	newImgCtner_img.className = 'img_ctner_temp';
	return newImgCtner_img;
}

function replaceSelected(name, newStr){
	var aa = [];
	var root = document.getElementById(name+"-editable");
	var nextRoot;
	var layer_num = selChildIndex.length;
	for(i = 0; i < layer_num ;  i++){
		var layer_size = root.children.length;
		aa[i] = [];
		for(j = 0; j<layer_size; j++ ){
			if(j == selChildIndex[i]){
				nextRoot = root.children[j].cloneNode(true);
				if(nextRoot.children.length && nextRoot.children[0].tagName != 'BR'){
					var temp_content = nextRoot.innerHTML;
					aa[i][j] = htmlToText(nextRoot).split(temp_content);
				}else{
					
					var temp_content = nextRoot.innerHTML;
					aa[i][j] = htmlToText(nextRoot).replace(temp_content, newStr);
					
				}
				
			}else{
				aa[i][j] = htmlToText(root.children[j]);
			}
		}
		root = nextRoot;
	}
	var temp_whole = "";
	
	for( i = layer_num-1 ; i >=0 ; i --){
		var preStr = "";
		var postStr = "";
		var pre = true;
		for( j = 0 ; j< aa[i].length ; j++){
			if( j == selChildIndex[i]){
				if(Array.isArray(aa[i][j])){
					pre = false;
					temp_whole = aa[i][j][0]+temp_whole+aa[i][j][1];
				}else{
					pre = false;
					temp_whole += aa[i][j];
				}
			}else{
				if(pre){
					preStr += aa[i][j];
				}else{
					postStr += aa[i][j];
				}
			}
			
		}
		temp_whole = preStr + temp_whole + postStr;
	}
	// console.log("temp_whole = "+temp_whole);
	// editor.innerHTML = temp_whole;
	return temp_whole;
};
/* ==========================================
			saved for the future
===========================================*/
function getSelectionHtml() {
    var html = "";
    if (typeof window.getSelection != "undefined") {
        var sel = window.getSelection();
        if (sel.rangeCount) {
            var container = document.createElement("div");
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                container.appendChild(sel.getRangeAt(i).cloneContents());
            }
            html = container.innerHTML;
        }
    } else if (typeof document.selection != "undefined") {
        if (document.selection.type == "Text") {
            html = document.selection.createRange().htmlText;
        }
    }
    return html;
}