$(function(){
	var timer_started = false;

	$(".choose-time").on('click',function() {
		if(timer_started) {
			return;
		}
		$(".time-drop-down").toggle();
		$(".drop-down-arrow.down").toggle();
		$(".drop-down-arrow.up").toggle();		
	});
	$(".time-drop-down div").on('click',function(event) {
		event.stopPropagation();	
		var minutes = $(this).data("minutes");
		$(".selected-time").text(minutes + " minutter");
		$(".selected-time").data("minutes",minutes);
		$(".selected-time").addClass("selected");
		$(".time-left").text(minutes+":00");
		$(".time-drop-down").toggle();
		$(".drop-down-arrow.down").toggle();
		$(".drop-down-arrow.up").toggle();				
	});
	
	$(".hour-glass").on('click',function() {
		var minutes = $(".selected-time").data("minutes");
		if(minutes == 0 || timer_started) {
			return;
		}
		var $hourglass = $(this).children("img");
		$hourglass.addClass("rotate");
		var time = minutes*60*1000;		
		var time_done = new Date().getTime()+time;
		timer_started = true;
		$(".time-progress").show();
		$(".time-progress").animate({
			width: "35.5em"
		}, {
			duration: time,
			easing: "linear",
			step: function() {
				var time_left = (time_done - new Date().getTime())/1000;
				var minutes = Math.max(Math.floor(time_left/60),0);
				var seconds = Math.max(Math.floor(time_left - (minutes*60)),0);
				if(seconds < 10) {
					$(".time-left").text(minutes+":0"+seconds);
				} else {
					$(".time-left").text(minutes+":"+seconds);
				}
			},
			complete: function() {
			$hourglass.removeClass("rotate");			
			timer_started = false;
			}
		});
	});
});