var sEvent = document.getElementsByClassName("event");
var sUpcoming_events = document.getElementsByClassName("upcoming-event");
var sArchive_events = document.getElementsByClassName("archive-event");
// var sUpcoming_events_img = document.getElementsByClassName("event_upcoming_img");
// var sArchive_events_img = document.getElementsByClassName("event_arch_img");
// var sEvent = [];
var sTn = [];
if(sUpcoming_events.length){
	var dev_X = sUpcoming_events[0].offsetLeft;
}else{
	var dev_X = sArchive_events[0].offsetLeft;
}

// for(i = 0; i < sUpcoming_events.length ; i++){
// 	(function(){
// 		var thisTn = sUpcoming_events_img[i];
// 		sUpcoming_events[i].addEventListener('mousemove', function(e){
// 			var mouseleft = e.pageX-dev_X;
// 			thisTn.style.left = mouseleft+"px";
// 		});
// 	})();
// }

[].forEach.call(sUpcoming_events, function(el, i){
	if(!el.classList.contains('noThumbnail')){
		var thisTn = el.querySelector('.event-thumbnail');
		el.addEventListener('mousemove', function(e){
			var mouseleft = e.pageX-dev_X;
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