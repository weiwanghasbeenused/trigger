var sEvent = document.getElementsByClassName("event");
var sEvent_upcoming = document.getElementsByClassName("event_upcoming");
var sEvent_arch = document.getElementsByClassName("event_arch");
var sEvent_upcoming_img = document.getElementsByClassName("event_upcoming_img");
var sEvent_arch_img = document.getElementsByClassName("event_arch_img");
// var sEvent = [];
var sTn = [];
if(sEvent_upcoming.length){
	var dev_X = sEvent_upcoming[0].offsetLeft;
}else{
	var dev_X = sEvent_arch[0].offsetLeft;
}

console.log(dev_X);

class Event {
	constructor(title, cato, tnUrl, date, time, location, mouse_x = 0){
		this.title = title;
		this.cato = cato;
		this.tnUrl = tnUrl;
		this.date = date;
		this.time = time;
		this.location = location;
		this.mouse_x = mouse_x;
	}
}


for(i = 0; i < sEvent_upcoming.length ; i++){
	(function(){
		var thisTn = sEvent_upcoming_img[i];
		sEvent_upcoming[i].addEventListener('mousemove', function(e){
			var mouseleft = e.pageX-dev_X;
			thisTn.style.left = mouseleft+"px";
		});
	})();
}
for(i = 0; i < sEvent_arch.length ; i++){
	(function(){
		var thisTn = sEvent_arch_img[i];
		sEvent_arch[i].addEventListener('mousemove', function(e){
			var mouseleft = e.pageX-dev_X;
			thisTn.style.left = mouseleft+"px";
		});
	})();
}