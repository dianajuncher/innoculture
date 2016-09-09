$(function(){

	$(".next-button,.prev-button").click(function() {
		var page = $(this).data("page");
		var new_page = $(this).data("new-page");
		$("#page-"+page).hide();
		$("#page-"+new_page).show();
	});

});