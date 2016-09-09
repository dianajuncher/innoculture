$(function(){

	var game_id = $("#manage").data("game-id");	
	var round = $("#manage").data("round");
	var is_closed = false;
	var max_areas = round*2;
	
	$(".group").click(function() {
		var group_number = $(this).data("group-number");
		
		$(".group").removeClass("selected");
		$(this).addClass("selected");
		
		$(".chips").hide();
		$(".chips-"+group_number).show();
		
		$(".area-container").hide();
		$(".area-container-"+group_number).show();
	});
	
	
	$(".flip").flip({
		trigger: 'manual',
		axis: 'y'
	});
	$(".flipped, .locked").each(function(index,element) {
		$(element).flip(true);
	});
	$(".flip").on('click',function(event) {
		var flipped = $(this).siblings(".flipped").length;
		if($(this).hasClass("flipped")) {
			var chips = parseInt($(this).find("span").text());
			if(chips > 0 || $(this).hasClass("locked")) {
		 		return;
		 	} else {
		 		$(this).flip(false);
		 		$(this).removeClass("flipped");
				flipped--;
		 	}
		} else if(flipped < max_areas) {
			$(this).flip(true);
			$(this).addClass("flipped");
			flipped++;
		}
	});

	$(".focus").click(function(event) {
		event.stopPropagation();
		var group_number = $(this).data("group-number");
		var area_id = $(this).data("area-id");	
		var focus_id = $(this).data("focus-id");
		var chips = parseInt($(this).children("span").text());
		var free_chips = parseInt($(".chips-"+group_number).children("span").text());
		
		var $focus = $(this);

		if(chips == 2 || free_chips==0) {
			$.post(siteurl + 'ajax/remove_chips',
			 	{
			 		"game_id": game_id,
			 		"group_number": group_number,
			 		"focus_id": focus_id,
			 		"chips": 2
			 	},
			 	function(data) {
			 		if(data.status=="ok") {
						free_chips = free_chips + chips;
						chips = 0;
						$focus.children("span").text(chips);
						$focus.removeClass("one-chip");
						$focus.removeClass("two-chips");
						$(".chips-"+group_number).children("span").text(free_chips);
				 	}
				 }, 'json');
		} else if(free_chips > 0) {
			$.post(siteurl + 'ajax/place_chip',
				{
					"game_id": game_id,
					"group_number": group_number,
					"area_id": area_id,
					"focus_id": focus_id
				},
				function(data) {
					if(data.status=="ok") {
						chips = chips + 1;
						free_chips = free_chips - 1;
						$focus.children("span").text(chips);
						$focus.addClass("one-chip");
						if(chips == 2) {
							$focus.removeClass("one-chip");
							$focus.addClass("two-chips");
						}
						$(".chips-"+group_number).children("span").text(free_chips);
					}
				}, 'json');
		}
	});
	

	$(".calculate-points").click(function(event) {
		var free_chips = 0;
		$(".chips-container .chips").each(function(index,element) {
			free_chips = free_chips + parseInt($(element).children("span").text());
		});

		if(free_chips==0) {
			$.post(siteurl + 'ajax/calculate_points',
				{
					"game_id": game_id,
					"round": round
				},
				function(data) {
					if(data.status=="ok") {
						is_closed = true;
					}
				}, 'json');
		} else {
			alert(free_chips + " jetoner tilbage!");
		}
	});
});