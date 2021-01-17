var sEvent = document.getElementsByClassName("event");
var sUpcoming_events = document.getElementsByClassName("upcoming-event");
var sArchive_events = document.getElementsByClassName("archive-event");
// var sEvents = document.getElementsByClassName('event');
// var sUpcoming_events_img = document.getElementsByClassName("event_upcoming_img");
// var sArchive_events_img = document.getElementsByClassName("event_arch_img");
// var sEvent = [];
var sTn = [];
var dev_X_upcoming = 80;
var thumbnail_width_arr = [];
var wW = window.innerWidth;
[].forEach.call(sUpcoming_events, function(el, i){
	if(!el.classList.contains('noThumbnail')){
		var thisTn = el.querySelector('.event-thumbnail');
		thumbnail_width_arr[i] = thisTn.offsetWidth;
		el.addEventListener('mousemove', function(e){
			var mouseleft = e.pageX-dev_X_upcoming;
			if(mouseleft < wW - thumbnail_width_arr[i] - dev_X_upcoming - 20)
				thisTn.style.left = mouseleft+"px";
		});
	}
});
var dev_X_archive = 270;
[].forEach.call(sArchive_events, function(el, i){
	if(!el.classList.contains('noThumbnail')){
		var thisTn = el.querySelector('.event-thumbnail');
		thumbnail_width_arr[i] = thisTn.offsetWidth;
		el.addEventListener('mousemove', function(e){
			var mouseleft = e.pageX-dev_X_archive;
			if(mouseleft < wW - thumbnail_width_arr[i] - dev_X_archive - 20)
				thisTn.style.left = mouseleft+"px";
		});
	}
});
// for(i = 0; i < sArchive_events.length ; i++){
// 	(function(){
// 		var thisTn = sArchive_events_img[i];
// 		sArchive_events[i].addEventListener('mousemove', function(e){
// 			var mouseleft = e.pageX-dev_X;
// 			thisTn.style.left = mouseleft+"px";
// 		});
// 	})();
// }