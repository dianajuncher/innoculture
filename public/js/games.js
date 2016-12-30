$(function(){
	
// NEW GAME
	$(".new-game-button").on('click',function() {		
		var $new_game = $(".new-game-container").clone();
		$new_game.removeClass("new-game-container");
		$new_game.find(".new-game-button").remove();
		$new_game.insertAfter(".new-game-container").hide().slideDown("slow",function() {
			$.post(siteurl + 'ajax/create_new_game',
			{},
			function(data) {
				if(data.status=="ok") {
					location.reload();			
				}
			}, 'json');
		});
	});

// EDIT GAME	
	$("textarea").on('click',function() {
		$(this).addClass('active');		
	});
	$("textarea").on('blur',function() {
		$(this).removeClass("active");
	});
	$("textarea").on('change',function() {
		var game_id = $(this).data("game-id");
		var value = $(this).val();
		$(this).removeClass("active");
		$.post(siteurl + 'ajax/update_new_game',
		{
			"game_id": game_id,
			"field": 'name',
			"value": value
		},
		function(data) {
			if(data.status=="ok") {
				check_setup(game_id);
			}
		}, 'json');				
	})
	
	$(".game-groups, .game-scenario").on('click',function() {
		$(this).children(".content").children("div").toggle();
	});
	$(".groups-drop-down div").on('click',function(event) {
		event.stopPropagation();
		var value = $(this).text();
		var $dropdown = $(this).parent();
		var game_id = $dropdown.data('game-id');
		$.post(siteurl + 'ajax/update_new_game',
		{
			"game_id": game_id,
			"field": 'groups',
			"value": value
		},
		function(data) {
			if(data.status=="ok") {
				$dropdown.siblings("span").text(value);
				$dropdown.toggle();
				check_setup(game_id);
			}
		}, 'json');
	});
	$(".scenarios-drop-down div").on('click',function(event) {
		event.stopPropagation();
		var company_name = $(this).text();
		var company_id = $(this).data('company-id');
		var $dropdown = $(this).parent();
		var game_id = $dropdown.data('game-id');
		$.post(siteurl + 'ajax/update_new_game',
		{
			"game_id": game_id,
			"field": 'company_id',
			"value": company_id
		},
		function(data) {
			if(data.status=="ok") {
				$dropdown.siblings("span").text(company_name);
				$dropdown.toggle();
				check_setup(game_id);
			}
		}, 'json');
	});	
	function check_setup(game_id) {
		var $game_container = $(".game-container-"+game_id);
		var game_name = $game_container.find(".game-name .content textarea").val();
		var groups = $game_container.find(".game-groups .content span").text();
		var scenario = $game_container.find(".game-scenario .content span").text();
		if(game_name.length > 0 && groups > 0 && scenario.length > 4) {
			$game_container.find(".game-start").addClass("active");
		} else {
			$game_container.find(".game-start").removeClass("active");
		}
	}
	
// START GAME
	$(".game-start").on('click',function() {
		if($(this).hasClass("active")) {
			var game_id = $(this).data('game-id');
			$.post(siteurl + 'ajax/start_new_game',
			{
				"game_id": game_id,
			},
			function(data) {
				if(data.status=="ok") {
					location.reload();			
				}
			}, 'json');
		}
	});
});