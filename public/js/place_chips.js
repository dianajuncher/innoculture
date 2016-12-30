$(function(){
	var game_id = $("#chips").data("game-id");	
	var round = $("#chips").data("round");
	var max_areas = round*2;	
	var round_status = $("#chips").data("status");

		
	// FLIP AREA
	$(".flip").flip({
		trigger: 'manual',
		axis: 'y'
	});
	$(".flipped, .locked").each(function(index,element) {
		$(element).flip(true);
	});
	
	$(".flip").on('click',function(event) {
		event.stopPropagation();		
		if(round_status=='closed') {
			return;
		}
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

	// PLACE / REMOVE CHIPS
	$(".focus").on("click",function(event) {
		event.stopPropagation();	
		if(round_status=='closed') {
			return;
		}		
		var group_number = $(this).data("group-number");
		var area_id = $(this).data("area-id");	
		var focus_id = $(this).data("focus-id");
		var chips = parseInt($(this).children("span").text());
		var free_chips = parseInt($(".free-chips .chips-"+group_number).children("span").text());
		var $focus = $(this);

		if(chips == 2 || free_chips==0 ) {
			$.post(siteurl + 'ajax/remove_all_chips',
			 	{
			 		"game_id": game_id,
			 		"group_number": group_number,
			 		"focus_id": focus_id,
			 	},
			 	function(data) {
			 		if(data.status=="ok") {
						free_chips = free_chips + chips;
						chips = 0;
						$focus.children("span").text(chips);
						$focus.removeClass("one-chip");
						$focus.removeClass("two-chips");
						$(".free-chips .chips-"+group_number).children("span").text(free_chips);
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
						$(".free-chips .chips-"+group_number).children("span").text(free_chips);
					}
				},'json');
		}
	});


	// SWITCH GROUP
	$(".group").on('tap', function() {
		var group_number = $(this).data("group-number");
		$(".group").removeClass("selected");
		$(this).addClass("selected");
		$(".free-chips .chips").hide();
		$(".free-chips .chips-"+group_number).show();
		$(".area-container").hide();
		$(".area-container-"+group_number).show();
	});
	
	
	// CLOSE ROUND
	$(".close-round").on('click', function(event) {
		if(round_status=='closed') {
			return;
		}
		var total_free_chips = 0;
		$(".free-chips .chips").each(function(index,element) {
			total_free_chips = total_free_chips + parseInt($(element).children("span").text());
		});
		if(total_free_chips > 0) {
			$(".close-round-popup .chips").show();
		} else {
			$(".close-round-popup .chips").hide();
		}
		$(".close-round-popup").show();
	});
	
	$(".close-round-popup .cancel").on('click', function() {
		$(".close-round-popup").hide();
	});
	$(".close-round-popup .ok").on('click', function() {
		$.post(siteurl + 'ajax/close_round',
			{
				"game_id": game_id,
				"round": round
			},
			function(data) {
				if(data.status=="ok") {
					$(".close-round-popup").hide();
					round_status = "closed";
				}
			}, 'json');
	});
});