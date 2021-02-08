function link_old() {
	var linkURL = prompt('Enter a URL:', 'http://');
	if (linkURL === null || linkURL === "") {
		return;
	}
	document.execCommand('createlink', false, linkURL);
}
function link(isBlank = false) {
    var linkURL = prompt('Enter a URL:', 'http://');
    var sText = document.getSelection();
    if(isBlank) 
    	document.execCommand('insertHTML', false, '<a href="' + linkURL + '" target="_blank">' + sText + '</a>');
    else
    	document.execCommand('insertHTML', false, '<a href="' + linkURL + '" >' + sText + '</a>');
}

function addWysiwygEditorListeners(thisWysiwygElement) {
	var isWysiwygContainer = thisWysiwygElement.classList.contains('wysiwyg-container');
	var thisWysiwygContainer = thisWysiwygElement.parentNode;
	var thisEditable = thisWysiwygElement.querySelector('.editable');
	if( thisWysiwygElement.classList.contains('wysiwyg-text-editor') )
	{
		var thisWysiwygTextEditor = thisWysiwygElement;

		var thisToolHtml = thisWysiwygElement.querySelector('.tool-html');
		if(thisToolHtml !== null){
			thisToolHtml.addEventListener('click', function(e) {
				resignImageContainer();
				sethtml(thisWysiwygElement);
			}, false);
		}
		var thisToolTxt = thisWysiwygElement.querySelector('.tool-txt');
		if(thisToolTxt !== null){
			thisToolTxt.addEventListener('click', function(e) {
			showrich(thisWysiwygElement);
			},false);
		}

		var thisToolBold = thisWysiwygElement.querySelector('.tool-bold');
		if(thisToolBold !== null)
			thisToolBold.addEventListener('click', function(e) {resignImageContainer();}, false);

		var thisToolItalic = thisWysiwygElement.querySelector('.tool-italic');
		if(thisToolItalic !== null)
			thisToolItalic.addEventListener('click', function(e) {resignImageContainer();}, false);

		var thisToolLink = thisWysiwygElement.querySelector('.tool-link');
		if(thisToolLink !== null)
			thisToolLink.addEventListener('click', function(e) {resignImageContainer();}, false);

		var thisToolIndent = thisWysiwygElement.querySelector('.tool-indent');
		if(thisToolIndent !== null)
			thisToolIndent.addEventListener('click', function(e) {resignImageContainer();}, false);

		var thisToolReset = thisWysiwygElement.querySelector('.tool-reset');
		if(thisToolReset !== null){
			thisToolReset.addEventListener('click', function(e) {
				showToolBar(thisWysiwygElement);
				commitAll();
			},false);
		}
		if(thisEditable !== null)
		{
			thisEditable.addEventListener('click', function(e) {
				resignImageContainer();
				showToolBar(thisWysiwygElement);
			},false);
			thisEditable.addEventListener('paste', function(e){
				setTimeout(
					function(){
						filterNodes(thisEditable, {br: [], a: [], b: [], strong: [], i: [], em: [], img: []});
					}, 
				0);
			});
		}
		
	}
	else if(thisWysiwygElement.classList.contains('wysiwyg-image-editor') )
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
	else
	{
		console.log('Received an unidenfitied wysiwyg editor...');
	}
}
function addWysiwygContainerListeners(thisWysiwygContainer) {
	var thisBtn_add_body_image = thisWysiwygContainer.querySelector('.btn-add-body-image');
	if(thisBtn_add_body_image !== null)
		thisBtn_add_body_image.addEventListener('click', ()=>addImageBlock(thisBtn_add_body_image, wysiwyg_image_editor_template));
	var thisBtn_add_body_text = thisWysiwygContainer.querySelector('.btn-add-body-text');
	if(thisBtn_add_body_text !== null)
		thisBtn_add_body_text.addEventListener('click', ()=>addTextBlock(thisBtn_add_body_text, wysiwyg_text_editor_template));
	var thisBtnDeleteSection = thisWysiwygContainer.querySelector('.btn-delete-section');
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
	var thisWysiwygElement = thisElement.parentNode.parentNode.parentNode.parentNode;
	var thisImg = thisWysiwygElement.querySelector('.image-holder img');
	var thisFigcaption = thisWysiwygElement.querySelector('.image-holder figcaption');
	thisImg.src = thisUrl;
	if(thisAlt !== '')
	{
		thisImg.setAttribute('alt', thisAlt);
		if(thisFigcaption !== null)
			thisFigcaption.innerText = thisAlt;	
	}
	else if(thisFigcaption !== null){
		thisFigcaption.parentNode.removeChild(thisFigcaption);
	}
	hideToolBars();
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

function addImageBlock(element, wysiwyg_image_template){
	hideToolBars();
	setTimeout(function(){
		var this_wysiwyg_image_editor = wysiwyg_image_template.cloneNode(true);
		element.parentNode.parentNode.insertBefore(this_wysiwyg_image_editor, element.parentNode);
		this_wysiwyg_image_editor.classList.add('displaying-imagecontainer');
		addWysiwygEditorListeners(this_wysiwyg_image_editor);
		return true;
	}, 0);
}
function addTextBlock(element, wysiwyg_text_template){
	hideToolBars();
	setTimeout(function(){
		var this_wysiwyg_text_editor = wysiwyg_text_template.cloneNode(true);
		element.parentNode.parentNode.insertBefore(this_wysiwyg_text_editor, element.parentNode);
		addWysiwygEditorListeners(this_wysiwyg_text_editor);
		return true;
		// wysiwyg_text_editor_clone = wysiwyg_text_editor_template.cloneNode(true);
	}, 0);
}
