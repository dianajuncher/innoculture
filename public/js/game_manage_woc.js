$(function(){

	var game_id = $("#woc").data("game-id");	
	var longclick = 750;
	var start;
	
	$(".group").click(function() {
		var group_number = $(this).data("group-number");
		$(".group").removeClass("selected");
		$(this).addClass("selected");
		$(".area-container").hide();
		$(".area-container-"+group_number).show();
	});
	
	$(".flip").flip({
		trigger: 'manual',
		axis: 'y'
	});
	$(".flip").on('mouseup touchend',function() {
		if($(this).hasClass("flipped")) {
			$(this).flip(false);
			$(this).removeClass("flipped");
		} else {
			$(this).flip(true);
			$(this).addClass("flipped");
		}
	});
	
	$(".area").on('mousedown touchstart',function(event) {
		event.stopPropagation();
		start = new Date().getTime();
	});
	$(".area").on('mouseup touchend', function(event) {
		event.stopPropagation();
		var group_number = $(this).data("group-number");
		var area_id = $(this).data("area-id");	
		var chips = parseInt($(this).children("span").text());
		var $area = $(this);
		
		if(new Date().getTime() >= (start+longclick) ) {
			if(chips > 0) {
				$.post(siteurl + 'ajax/remove_chip_woc',
					{
						"game_id": game_id,
						"group_number": group_number,
						"area_id": area_id,
						"focus_id": 0
					},
					function(data) {
						if(data.status=="ok") {
							chips--;
							$area.children("span").text(chips);
						}
					}, 'json');
			}
		} else {
			$.post(siteurl + 'ajax/place_chip_woc',
				{
					"game_id": game_id,
					"group_number": group_number,
					"area_id": area_id,
					"focus_id": 0
				},
				function(data) {
					if(data.status=="ok") {
						chips++;
						$area.children("span").text(chips);
					}
				}, 'json');			
		}
	});
	$(".focus").on('mousedown touchstart',function(event) {
		start = new Date().getTime();
		event.stopPropagation();
	});
	$(".focus").on('mouseup touchend',function(event) {		
		event.stopPropagation();
		var group_number = $(this).data("group-number");
		var area_id = $(this).data("area-id");	
		var focus_id = $(this).data("focus-id");
		var chips = parseInt($(this).children("span").text());
		var $focus = $(this);
		
		if(new Date().getTime() >= (start+longclick) ) {
			if(chips > 0) {
				$.post(siteurl + 'ajax/remove_chip_woc',
					{
						"game_id": game_id,
						"group_number": group_number,
						"area_id": area_id,
						"focus_id": focus_id
					},
					function(data) {
						if(data.status=="ok") {
							chips--;
							$focus.children("span").text(chips);
						}
					}, 'json');				
			}
		} else {
			$.post(siteurl + 'ajax/place_chip_woc',
				{
					"game_id": game_id,
					"group_number": group_number,
					"area_id": area_id,
					"focus_id": focus_id
				},
				function(data) {
					if(data.status=="ok") {
						chips++;
						$focus.children("span").text(chips);
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