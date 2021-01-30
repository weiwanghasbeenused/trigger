function link() {
	var linkURL = prompt('Enter a URL:', 'http://');
	if (linkURL === null || linkURL === "") {
		return;
	}
	document.execCommand('createlink', false, linkURL);
}

function addListeners(thisWysiwygElement) {
	var isWysiwygContainer = thisWysiwygElement.classList.contains('wysiwyg-container');
	var thisWysiwygContainer = isWysiwygContainer ? thisWysiwygElement : thisWysiwygElement.parentNode;
	var thisEditable = thisWysiwygElement.querySelector('.editable');
	if( thisWysiwygElement.classList.contains('wysiwyg-text-editor') || 
		isWysiwygContainer
	)
	{
		var thisWysiwygTextEditor = isWysiwygContainer ? thisWysiwygContainer.querySelector('.wysiwyg-text-editor') : thisWysiwygElement;

		var thisToolHtml = thisWysiwygElement.querySelector('.tool-html');
		if(thisToolHtml !== null){
			thisToolHtml.addEventListener('click', function(e) {
				// e = e || window.event;
				// var thisElement = e.target || e.srcElement; 
				resignImageContainer();
				sethtml(thisWysiwygTextEditor);
			}, false);
		}
		var thisToolTxt = thisWysiwygElement.querySelector('.tool-txt');
		if(thisToolTxt !== null){
			thisToolTxt.addEventListener('click', function(e) {
			// e = e || window.event;
			// var thisElement = e.target || e.srcElement; 
			showrich(thisWysiwygTextEditor);
			},false);
		}
		thisWysiwygElement.querySelector('.tool-bold').addEventListener('click', function(e) {
			resignImageContainer();}, 
			false);
		thisWysiwygElement.querySelector('.tool-italic').addEventListener('click', function(e) {
			resignImageContainer();}, 
			false);
		thisWysiwygElement.querySelector('.tool-link').addEventListener('click', function(e) {
			resignImageContainer();}, 
			false);
		thisWysiwygElement.querySelector('.tool-indent').addEventListener('click', function(e) {
			resignImageContainer();}, 
			false);
		thisWysiwygElement.querySelector('.tool-reset').addEventListener('click', function(e) {
			showToolBar(thisWysiwygTextEditor);
			commitAll();
		},false);
		thisEditable.addEventListener('click', function(e) {
			resignImageContainer();
			showToolBar(thisWysiwygTextEditor);
		},false);
		thisEditable.addEventListener('paste', function(e){
			setTimeout(
				function(){
					filterNodes(thisEditable, {br: [], a: [], b: [], i: [], img: []});
				}, 
			0);
		});
	}
	else
	{
		var thisImageHolder = thisWysiwygElement.querySelector('.image-holder');
		if(thisImageHolder !== null)
		{
			thisImageHolder.addEventListener('click', function(e) {
				showToolBar(thisWysiwygElement);
				image(thisWysiwygElement);
			}, 
			false);
		}
		var thisImageContainer = thisWysiwygElement.getElementsByClassName('image-container');
		if(thisImageContainer != null)
		{
			[].forEach.call(thisImageContainer, function(el, i){
				el.addEventListener('click', function(e){
					resignImageContainer();
					e = e || window.event;
					var thisElement = e.target || e.srcElement;
					thisEditable.focus();
					var thisImagePath = el.getAttribute('img-path');
					insertBodyImage(thisElement);
				});
			});
		}
		var thisBtnDeleteImage = thisWysiwygElement.querySelector('.btn-delete-image');
		thisBtnDeleteImage.addEventListener('click', function(){
			thisWysiwygElement.parentNode.removeChild(thisWysiwygElement);
		});
	}
	
	if( isWysiwygContainer ){
		var thisBtnDeleteSection = thisWysiwygElement.querySelector('.btn-delete-section');
		if(thisBtnDeleteSection !== null){
			thisBtnDeleteSection.addEventListener('click', function(e) {
				e = e || window.event;
				var thisElement = e.target || e.srcElement;
				var thisSection = thisElement.parentNode;
				thisSection.parentNode.removeChild(thisSection);
				section_number--;
			},false);
		}
	}
}
function resignImageContainer() { 
	var sDisplaying_imagecontainer = document.getElementsByClassName('displaying-imagecontainer');
	if(sDisplaying_imagecontainer.length != 0)
	{
		[].forEach.call(sDisplaying_imagecontainer, function(el, i){
			el.classList.remove('displaying-imagecontainer');
		});
	}
}
function image(thisWysiwygElement) {
	thisWysiwygElement.classList.add('displaying-imagecontainer');
}

function showToolBar(thisWysiwygElement) {
	hideToolBars();
	thisWysiwygElement.classList.add('displaying-toolbar');
}

function hideToolBars() {
	var sDisplaying_toolbar = document.getElementsByClassName('displaying-toolbar');
	if(sDisplaying_toolbar.length != 0)
	{
		[].forEach.call(sDisplaying_toolbar, function(el, i){
			el.classList.remove('displaying-toolbar');
		});
	}
	
	resignImageContainer();
}

function commitAll() {
	var sWysiwygEditor = document.querySelectorAll('.wysiwyg-image-editor, .wysiwyg-text-editor');
	[].forEach.call(sWysiwygEditor, function(el, i){
		commit(el);
	});
}
function commit(thisWysiwygElement) {

	var editable = thisWysiwygElement.querySelector('.editable');
	var textarea = thisWysiwygElement.querySelector('textarea');
	console.log(thisWysiwygElement);
	if ( !thisWysiwygElement.classList.contains('displaying-html')) {
		var html = editable.innerHTML;
		textarea.value = html;    // update textarea for form submit
	} else {
		var html = textarea.value;
		editable.innerHTML = html;    // update editable
	}
	// console.log([name, editable.style.display, textarea.style.display]);
}

function showrich(thisWysiwygTextEditor) {
	// if(thisElement.classList.contains('wysiwyg-container'))
	// {
	// 	var thisWysiwygElement = thisElement;
	// }
	// else
	// 	var thisWysiwygElement = thisElement.parentNode.parentNode;
	thisWysiwygTextEditor.classList.remove('displaying-html');
	var textarea = thisWysiwygTextEditor.querySelector('textarea');
	var editable = thisWysiwygTextEditor.querySelector('.editable');

	var html = textarea.value;
	editable.innerHTML = html;    // update editable
}

function sethtml(thisWysiwygTextEditor) {
	thisWysiwygTextEditor.classList.add('displaying-html');
	var textarea = thisWysiwygTextEditor.querySelector('textarea');
	var editable = thisWysiwygTextEditor.querySelector('.editable');

	var html = editable.innerHTML;
	textarea.value = pretty(html);    // update textarea for form submit
	window.scrollBy(0, textarea.getBoundingClientRect().top); // scroll to the top of the textarea
}

function resetViews() {
	commitAll();
	var sWysiwyg_container = document.getElementsByClassName('wysiwyg-container');
	[].forEach.call(sWysiwyg_container, function(el, i){
		showrich(el);
	});

	for (var i = 0; i < names.length; i++) {
		if (!(name && name === names[i]))
			showrich(names[i]);
	}
}
function insertBodyImage(thisElement){
	var thisUrl = thisElement.getAttribute('img-path') || thisElement.getAttribute('src');
	var thisAlt = thisElement.getAttribute('alt') || '';
	var thisWysiwygElement = thisElement.parentNode.parentNode.parentNode.parentNode.parentNode;
	var thisImg = thisWysiwygElement.querySelector('.image-holder img');
	var thisP = thisWysiwygElement.querySelector('.image-holder p');
	thisImg.src = thisUrl;
	
	thisImg.setAttribute('alt', thisAlt);
	thisP.innerText = thisAlt;	
	hideToolBars();
	// document.execCommand("insertImage", 0, "'. $medias[$i]['fileNoPath'] .'");	
}
// pretifies html (barely) by adding two new lines after a </div>
function pretty(str) {
	while(str.charCodeAt(0) == '9' || str.charCodeAt(0) == '10'){
		str = str.substring(1, str.length);
	}
    // return (str + '').replace(/(?<=<\/div>)(?!\n)/gi, '\n\n');
    return str;
}

function getSelectionText() {
    var text = "";
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        text = document.selection.createRange().text;
    }
    return text;
}

function indent(name){
    document.execCommand('formatBlock',false,'blockquote');
}

function reset(name){
    document.execCommand('formatBlock',false,'div');
    document.execCommand('removeFormat',false,'');
}

// filter tags for body text
// Example: filterNodes(o.node, {p: [], br: [], a: ['href']});

// Remove elements and attributes that do not meet a whitelist lookup of lowercase element
// name to list of lowercase attribute names.
//
function filterNodes(element, allow) {
    // Recurse into child elements
    //
    Array.fromList(element.childNodes).forEach(function(child) {
        if (child.nodeType===1) {
            filterNodes(child, allow);

            var tag= child.tagName.toLowerCase();
            if (tag in allow) {

                // Remove unwanted attributes
                //
                Array.fromList(child.attributes).forEach(function(attr) {
                    if (allow[tag].indexOf(attr.name.toLowerCase())===-1)
                       child.removeAttributeNode(attr);
                });

            } else {

                // Replace unwanted elements with their contents
                //
                while (child.firstChild)
                    element.insertBefore(child.firstChild, child);
                element.removeChild(child);
            }
        }
    });
}

// ECMAScript Fifth Edition (and JavaScript 1.6) array methods used by `filterNodes`.
// Because not all browsers have these natively yet, bodge in support if missing.
//
if (!('indexOf' in Array.prototype)) {
    Array.prototype.indexOf= function(find, ix /*opt*/) {
        for (var i= ix || 0, n= this.length; i<n; i++)
            if (i in this && this[i]===find)
                return i;
        return -1;
    };
}
if (!('forEach' in Array.prototype)) {
    Array.prototype.forEach= function(action, that /*opt*/) {
        for (var i= 0, n= this.length; i<n; i++)
            if (i in this)
                action.call(that, this[i], i, this);
    };
}

// Utility function used by filterNodes. This is really just `Array.prototype.slice()`
// except that the ECMAScript standard doesn't guarantee we're allowed to call that on
// a host object like a DOM NodeList, boo.
//
Array.fromList= function(list) {
    var array= new Array(list.length);
    for (var i= 0, n= list.length; i<n; i++)
        array[i]= list[i];
    return array;
};

function outsideClick(event, notelem)	{
    var clickedOut = true, 
    	i, 
    	len = notelem.length;
    if(typeof len == 'undefined'){
		if (event.target == notelem || notelem.contains(event.target)) {
            clickedOut = false;
        }
    }else{
    	for (i = 0;i < len;i++)  {
	        if (event.target == notelem[i] || notelem[i].contains(event.target)) {
	            clickedOut = false;
	        }
	    }
    }
    if (clickedOut) 
    	return true;
    else 
    	return false;
}
