<?
require_once('views/search.php');
?>
<script>

	var sSubmit_search = document.getElementById('submit_search');
	var sSubmit_clear = document.getElementById('clear_search');
	var sSsearch_form = document.getElementById('search_form');
	var sKeyword = document.getElementById('keyword');
	sSubmit_search.addEventListener('click', function(){
		sSsearch_form.submit();
	});
	sSubmit_clear.addEventListener('click', function(){
		sKeyword.value = '';
		sSsearch_form.submit();
	});

	var sNav = document.getElementById('nav');
	var nav_bottom = sNav.offsetTop + sNav.offsetHeight;
	var sSearch_ctner = document.getElementById('search_ctner');
	sSearch_ctner.style.top = nav_bottom + 'px';

</script>
