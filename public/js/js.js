$(document).ready(function () {

	$("#login-button").on("click", function() {
		var $templates = $("#templates");
		var $window = $templates.find(".window").clone();
		var $overlay = $templates.find(".overlay").clone();
		$window.find("form").attr("action", $(this).data("action"));
		$window.find(".title").text($(this).data("title"));
		$window.find("button").text($(this).data("button"));
		$window.appendTo("#ajax-wrapper");
		$overlay.appendTo("#ajax-wrapper");

		return false;
	});

});