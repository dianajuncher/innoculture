$(function(){

	var game_id = $("#manage").data("game-id");	
	
	$(".close-round").click(function() {
		$.post(siteurl + 'ajax/close_round',
			{
				"game_id": game_id
			}, function(data) {
				if(data.status=="ok") {
					location.reload();
				}
			}, 'json');
	});
	$(".open-round").click(function() {
		$.post(siteurl + 'ajax/open_round',
			{
				"game_id": game_id
			}, function(data) {
				if(data.status=="ok") {
					location.reload();
				}
			}, 'json');
	});


});