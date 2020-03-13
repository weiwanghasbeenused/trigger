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

function sethtml(name) {
	var sToolbar = document.getElementById(name + '-toolbar');
	var editable = document.getElementById(name + '-editable');
	var textarea = document.getElementById(name + '-textarea');
	sToolbar.classList.toggle('reverse');
	textarea.classList.toggle('hidden');
	editable.classList.toggle('hidden');

	var passString = editable.innerHTML;
	textarea.value = pretty(passString);
}

function showrich(name) {
	var sToolbar = document.getElementById(name + '-toolbar');
	var editable = document.getElementById(name + '-editable');
	var textarea = document.getElementById(name + '-textarea');
	sToolbar.classList.toggle('reverse');
	textarea.classList.toggle('hidden');
	editable.classList.toggle('hidden');

	var passString = textarea.value;
	editable.innerHTML = passString;
}
// ==============================================================

function pretty(str) {
	// Format the string to be wrapped only in p.body:
	// if the str has been prettified or not;
	var beenPrettied = str.indexOf('p class="body"');
	var firstDivIndex = str.indexOf("<div>");
	var noDivAtBeginning = false;
	// Sometimes the first paragraph will be wrapped nothing
	if(beenPrettied == -1){
		if(firstDivIndex != 0){
			noDivAtBeginning = true;
		}
		if(firstDivIndex != -1 ){
			// got some divs
			if(noDivAtBeginning){
				// if there's no div for first paragraph
				// then give wrap it with a div
				var preFirstDiv = str.slice(0, firstDivIndex);
				var postFirstDiv = str.slice(firstDivIndex);
				str = '<div>'+preFirstDiv+'</div>'+	postFirstDiv
			}
			str = str.replace(/<div>/gi,'<p class="body">');
			str = str.replace(/<\/div>/gi,"</p>");
		}else{
			// no div at all
			str = '<p class="body">'+str+"</p>";
		}
		// str = '<div class="content_section">'+str+'</div>';	
	}else{
		str = str.replace(/<div>/gi,'<p class="body">');
		str = str.replace(/<\/div>/gi,"</p>");
	}
	

	var isBrFree = str.indexOf("<br");
	if (isBrFree !== -1){
		str = str.replace(/<br\s*[\/]?>/gi,'<\/p><p class="body">');
	}
	str = str.replace(/<p class="body"><\/p>/gi,'');  
	stripEmptyTags('body'); 
	return str; 
}

function stripEmptyTags(name){
	// remove all the empty elements
	// which result from addTag() (or other causes);
	var editor = document.getElementById(name+"-editable");
	var editorChilds = editor.children;
	var isClean = true;
	var loopfuse = 0;
	do{	
		isClean = true;
		for(i = 0; i<editorChilds.length;i++){
			var editorGrandChilds = editorChilds[i].children;
			for(j= 0;j<editorGrandChilds.length;j++){
				if(!editorGrandChilds[j].innerHTML){
					editorChilds[i].removeChild(editorGrandChilds[j]);
					isClean = false;
				}else if(editorGrandChilds[j].innerHTML == ""){
					editorChilds[i].removeChild(editorGrandChilds[j]);
					isClean = false;
				}
			}
		}

	}while(!isClean);
}

function rmSpan(name){
	var span = document.querySelectorAll('#'+name+'-editable span');
	while(span.length) {
	    var parent = span[ 0 ].parentNode;
	    while( span[ 0 ].firstChild ) {
	        parent.insertBefore(  span[ 0 ].firstChild, span[ 0 ] );
	    }
	    parent.removeChild( span[ 0 ] );
	}
}
function replaceDivWithP(name){
	// var div = document.getElementsByTagName('div');
	var div = document.querySelectorAll("#"+name+"-editable div");
	var index = 0;
	while(div.length) {
		if(div[index].cliassList.contains('content_section')){
			index++;
		}else{
			var parent = div[ index ].parentNode;
		    // while( div[ index ].firstChild ) {
		    var temp_p = document.createElement("p");
		    temp_p.className = "body";
		    temp_p.innerHTML = div[ index ].firstChild;
	        parent.insertBefore(  temp_p, div[ index ] );
		    // }
		    parent.removeChild( div[ index ] );
		}
	    
	}
}

var selText = "";
var selRange = [];
var selected_el = null;
var selectedParentNodeOrder = -1;
var selectedGrandParentNodeOrder = -1;
var selParentIndex = [];
var selChildIndex = [];

function setSelection(origin){
	var origin_id = origin+"-editable";
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
	var temp_element = document.createElement("span");
	temp_element.innerHTML = selText;
	selText = stripNbsp(temp_element.innerHTML);
	var rr = sel.getRangeAt(0);	
	selected_el = rr.startContainer;
	while(selected_el.nodeType == 3){
		selected_el = selected_el.parentElement;
	}
	var rr_test = document.createRange();
	rr_test.selectNode(selected_el);
	rr_test.className = 'active';
	selRange[0] = rr.startOffset;
	selRange[1] = rr.endOffset;
	if(selRange[0] == 0 && selRange[1] == 0 && selText.length > 0){
		// if the text includes line break at the end;
		selText = selText.substring(0, selText.length - 2);
		selRange[1] = selText.length;
	}
	
	var rr_ancestor = [];
	var generation_el = selected_el,
		generation_el_id = generation_el.id,
		generation_count = 0;
	while(generation_el_id != origin_id){
		rr_ancestor[generation_count] = document.createRange();
		rr_ancestor[generation_count].selectNode(generation_el);
		selParentIndex[generation_count] = rr_ancestor[generation_count].startOffset;
		generation_el_id = rr_ancestor[generation_count].startContainer.id;
		generation_el = generation_el.parentElement;
		generation_count++;
	}
	for (i = 0;i<selParentIndex.length;i++){
		var order_reversed = selParentIndex.length-i-1;
		selChildIndex[order_reversed] = selParentIndex[i];
	}
}
var addListeners_selection = function(name){
	document.getElementById(name+"-editable").addEventListener('mouseup', function(){
		setSelection(name);
	});
	document.getElementById(name+"-editable").addEventListener('keyup', function(event){
		// if right arrow or left arrow;
		if (event.keyCode === 37 || event.keyCode === 38 || event.keyCode === 39 || event.keyCode === 40) {
		   setSelection(name);
		}
	});
}
var aa = [];
var temp_whole = "";
var addTag = function(name, tagName, newclass, imgContent = null){
	if(selected_el){
		editingCommit(name);
		var editor = document.getElementById(name+"-editable");
		var textarea = document.getElementById(name + '-textarea');
		var fullContent = selected_el.innerHTML;
		var tagName = tagName;
		// var thisEditorChild = [];
		// var temp_child = editor;
		// for (i = 0;i<selChildIndex.length;i++){
		// 	temp_child = temp_child.childNodes[selChildIndex[i]];
		// 	thisEditorChild[i] = temp_child;

		// }
		if(fullContent.indexOf(selText)!= -1 ){
			var tempText = [];
			tempText[0] = fullContent.slice(0, selRange[0]);
			tempText[1] = fullContent.slice(selRange[0], selRange[1]);
			tempText[2] = fullContent.slice(selRange[1], fullContent.length);

			if(newclass == 'subtitle'){
				tempText[0] += '</p></div><div class="content_section">';
				tempText[2] = '<p class="body">'+tempText[2];
				tempText[1] = '<'+tagName+" class = '"+newclass+"'>"+tempText[1]+"</"+tagName+">";
			}else if(mewclass == 'img_ctner'){
				tempText[0] += '</p>';
				tempText[2] = '<p class="body">'+tempText[2];
				tempText[1] = '<'+tagName+" class = '"+newclass+"'>"+imgContent+"</"+tagName+">";
			}

			var modifiedContent = tempText[0] + tempText[1] + tempText[2];
			
			// var aa = [];
			aa = [];
			var root = editor;
			var nextRoot;
			var layer_num = selChildIndex.length;
			for(i = 0; i < layer_num ;  i++){
				var layer_size = root.children.length;
				aa[i] = [];
				for(j = 0; j<layer_size; j++ ){
					if(j == selChildIndex[i]){
						nextRoot = root.children[j].cloneNode(true);
						if(nextRoot.children.length){
							var temp_content = nextRoot.innerHTML;
							aa[i][j] = htmlToText(nextRoot).split(temp_content);
						}else{
							var temp_content = nextRoot.innerHTML;
							aa[i][j] = htmlToText(nextRoot).replace(temp_content, modifiedContent);
						}
						
					}else{
						aa[i][j] = htmlToText(root.children[j]);
					}
				}
				root = nextRoot;
			}

			// var temp_whole = "";
			temp_whole = "";
			
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
			editor.innerHTML = temp_whole;
			stripEmptyTags(name);
			rmSpan(name);
			editingCommit(name);
			selText = "";
			selRange = [];
			selected_el = null;
			selParentIndex = [];
			selChildIndex = [];
		}else{

		}

	}else{
		console.log("this text can not be modified");
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

function commit(name) {
	var editable = document.getElementById(name + '-editable');
	var textarea = document.getElementById(name + '-textarea');
	if (textarea.classList.contains('hidden')) {
		var html = editable.innerHTML;
		textarea.value = html;    // update textarea for form submit
	} else {
		var html = textarea.value;
		editable.innerHTML = html;    // update editable
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


var addListeners_paste = function(name){
	var editable = document.getElementById(name+'-editable');
		editable.addEventListener('paste', (event) => {
		var paste_content = (event.clipboardData || window.clipboardData).getData('text/html');
		var temp_element = document.createElement("div");
		    temp_element.setAttribute('contenteditable', true);
		editingCommit(name);
		if(!editable.innerText || editable.innerText == ""){
			
			if(editable.innerHTML != editable.innerText){
				editable.innerHTML = "";
			}
		    if(!paste_content){
		    	var paste_content = (event.clipboardData || window.clipboardData).getData('text/plain');
			}
		    // temp_element.innerHTML = stripTags(paste_content);

		    temp_element.innerHTML = stripTags(paste_content);
		    editable.innerHTML = '<div class = "content_section">'+pretty(temp_element.innerHTML)+'</div>';
		    


		    event.preventDefault();

		}else{
			if(paste_content){
				event.preventDefault();
			    temp_element.innerHTML = stripNbsp(stripTags(paste_content));
			    var str = selected_el.innerText.substring(0, selRange[0])+temp_element.innerText+selected_el.innerText.substring(selRange[0]);
			    selected_el.innerText = str;
			    editable.innerHTML = pretty(editable.innerHTML);

			    var ee = editable;
			    
			    for(i = 0; i<selChildIndex.length ; i++){
			    	ee = ee.childNodes[selChildIndex[i]];
			    }
			    setCaretPosition(ee, selRange[0]+temp_element.innerHTML.length);
			    setTimeout(function(){
			    	rmSpan(name);
			    	stripEmptyTags(name);
			    },0);
		    }else{
		    	var paste_content = (event.clipboardData || window.clipboardData).getData('text/plain');
		    	setTimeout(function(){
		    		editable.innerHTML = pretty(editable.innerHTML);
		    		stripEmptyTags(name);
		    	}, 0);
		    }
		}
		
	});
}

  
var editingCommit = function(name){
	for(i = 0; i< unDoSteps ; i++){
		unDo.shift();
	}
	unDoSteps = 0;
    saveHTML(name);
}
var addListeners_input = function(name){
	document.getElementById(name+"-editable").addEventListener("input", function() {
		if(unDoSteps>-1){
			// editingCommit(name);
		}
	}, false);
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
function setCaretPosition(elm, pos) {
 	 var tag = elm; 

	// Creates range object 
	var setpos = document.createRange(); 
	  
	// Creates object for selection 
	var set = window.getSelection(); 
	 console.log(tag);
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
}
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