
<div id = 'admin-manual_ctner' class = 'main_ctner'>
	<div id = 'google-doc_ctner'>
	<iframe id = 'google-doc' src="https://docs.google.com/document/d/1q39MUW2iMQZHO6ytZ5Pty8pC-HeexojBIoXHXa3NURo/edit?usp=sharing"></iframe>>
	</div>
	<div id = 'bookmark_ctner'>
		<ol>
			<li class = 'bookmark' bookmark = 'id.w90c74vqmiad'>Open Records Generator</li>
			<li class = 'bookmark' bookmark = 'id.5sjwvctxjwu6'>編輯 About</li>
			<li class = 'bookmark_holder'><span class = 'bookmark' bookmark = 'id.ftae6uvlv2pl'>新增/編輯 Event</span>
				<ul class = 'bookmark_submenu'>
					<li class = 'bookmark' bookmark = 'id.osgkczosw1bf' >Upcoming</li>
					<li class = 'bookmark' bookmark = 'id.zcm00e8fefwv' >Archived</li>
				</ul>
			</li>
			<li class = 'bookmark' bookmark = 'id.o7i7ee63aqk3'>新增/編輯 Artist Index</li>
			<li class = 'bookmark' bookmark = 'id.1k3enychf6gc'>新增/編輯 Resource</li>
		</ol>
	</div>
</div>

<style>
*{
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}
html{
	font-size: 14px;
}
body{
	width: 100vw;
	max-width: 100%;
	height: 100vh;
	overflow: hidden;
	font-family: sans-serif;
	font-size: 1rem;
}
iframe{
	width: 100%;
	height: 100%;
	border: none;
}
#bookmark_ctner{
	position: fixed;
	z-index: 1000;
	top: 0;
	left: 0;
	top: 20%;
	transform:translate(0, -50%);
	padding: 20px 30px;
	background-color: #eee;
	box-shadow: 5px 5px 1px rgba(0,0,0,.75);
}
.bookmark{
	cursor:pointer;
}
.bookmark:hover{
	background-color: #fff;
}
.bookmark_submenu{
	margin-left: 15px;
	margin-bottom: 5px;
}
</style>

<script>
	var base_url = 'https://docs.google.com/document/d/1q39MUW2iMQZHO6ytZ5Pty8pC-HeexojBIoXHXa3NURo/edit';
	var base_url_query = 'usp=sharing';
	var sBookmark = document.getElementsByClassName('bookmark');
	var sIframe = document.getElementById('google-doc');
	Array.prototype.forEach.call(sBookmark, function(el, i){
		el.addEventListener('click', function(){
			var thisBookmark = el.getAttribute('bookmark');
			sIframe.src = base_url+'#bookmark='+thisBookmark;
		});
	});

</script>