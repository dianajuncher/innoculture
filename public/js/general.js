$(function(){
	
// NAVIGATION
	$(".menu-button").click(function() {
		$(".menu-button").hide();
		if($(".menu-dropdown").is(":hidden")) {
			$(".menu-dropdown").slideDown();
			$(".menu-close").show();
		} else {
			$(".menu-dropdown").slideUp();
			$(".menu-open").show();
		}
	});


// GAME LIST
	$("#game-list .game-select").click(function() {
		var game_id = $(this).data('game-id');
		$.post(siteurl + 'ajax/select_game',
	 	{
	 		"game_id": game_id,
	 	},
	 	function(data) {
	 		if(data.status=="ok") {
				return true;
		 	} else {
		 		return false;
		 	}
		}, 'json');	
	});
});