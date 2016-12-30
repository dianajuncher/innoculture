$(function(){
	var game_id = $("#result").data("game-id");	
	var pos_left;
	var pos_top;
	
	$(".area").on('tap', function(event) {
		if($(this).hasClass("open")) {
			var cells = $(".group-container").find("div.point-show");
			$(cells).animate({boxShadow: '0 0 0 #fff'});			
			$(cells).addClass("point-done");
			$(cells).removeClass("point-show");
			$("#overlay").hide();			
			$(this).animate( {
				left: pos_left,
				top: pos_top,
				fontSize: '100%'
			}, 800, function() {
				$(this).css("z-index", 1);				
				$(this).removeClass("open");
				$(this).addClass("done");
			});			
		} else {
			pos_left = $(this).css("left");
			pos_top = $(this).css("top");
			$(this).data("left",pos_left);
			$(this).data("top",pos_top);
			$(this).css("z-index", 10);
				$(this).addClass("open");			
			$(this).animate( {
				left: '-0.75em',
				top: '0em',
				fontSize: '315%'
			}, 800, function() {
				$(this).find("div").css({"background": "transparent"});
				$(this).find("span").css({"display": "block"});
				$("#overlay").show();
				if($(this).hasClass("done")) {
					return;
				}
				$.post(siteurl + 'ajax/get_points_of_groups_in_area',
			 	{
			 		"game_id": game_id,
			 		"area_id": $(this).data("area-id")
			 	},
			 	function(data) {
			 		if(data.status=="ok") {
						$.each(data.points, function(group,points) {
							if(points>0) {
								for(i=1;i<=points;i++) {
									var cell = $(".group-"+group).find("div.point").last();
									$(cell).addClass("point-show");
									$(cell).removeClass("point");
								}
								$(".group-"+group).find(".point-show").animate({boxShadow: '0 0 5px #fff'});
							}
						});
				 	}
				 }, 'json');
			});
		}
	});
	
	$("#overlay").on('tap', function() {
		var area = $(".gameboard-container").find("div.open");
		var cells = $(".group-container").find("div.point-show");
		$(cells).animate({boxShadow: '0 0 0 #fff'});			
		$(cells).addClass("point-done");
		$(cells).removeClass("point-show");
		$("#overlay").hide();
		$(area).animate( {
			left: pos_left,
			top: pos_top,
			fontSize: '100%'
		}, 800, function() {
			$(area).css("z-index", 1);				
			$(area).removeClass("open");
			$(area).addClass("done");
		});
	});	
				
});