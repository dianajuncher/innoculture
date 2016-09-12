$(function(){
	var max_points = $(".leaderboard-container").data("max-points");
	var max_width = 70;
	var point_width = max_width/max_points;

	$(".score-bar").each(function(index,element) {
		var points =  parseInt($(this).data('points'));
		var width = points*point_width;
		$(this).animate({
			width: width+'em'
		}, 1000, function() {
			$(".group-score.leader").css("background-color","#90d5f0");
		})
	});
});