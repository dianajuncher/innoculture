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
	
});