<div id = 'search_ctner'>
	<form id = 'search_form' action = '/artist-index' method = 'POST'>
		<div id = 'clear_search' class = 'search_btn'>
			<svg viewBox = '0 0 100 100'>
				<polygon class="cls-1" points="88.67 21.11 78.91 11.35 50.02 40.24 21.11 11.33 11.35 21.09 40.26 50 11.33 78.93 21.13 88.65 50.02 59.76 78.93 88.67 88.65 78.87 59.78 50 88.67 21.11"/>
			</svg>
		</div>
		<input id = 'keyword' name = 'keyword' value = '<? echo $keyword; ?>'>
		<div id = 'submit_search' class = 'search_btn'>
			<svg viewBox = '0 0 100 100'>
				<polygon class="cls-1" points="66.26 8.13 55.76 17.08 77.92 43.08 4 43.08 4 56.88 77.96 56.88 55.76 82.92 66.26 91.87 96 55.98 96 43.98 66.26 8.13"/>
			</svg>
		</div>
		
	</form>
</div>