$(document).ready(function () {

	$ajaxWrapper = $("#ajax-wrapper");
	$templates = $("#templates");
	$loader = $templates.find(".loader");
	$forms = $("#forms");
	$errors = $("#errors");

	$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	$(window).resize(function () {
		$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	});

	$("#login-button").on("click", function () {
		(new Window({
			name: $(this).data("name"),
			title: $(this).data("title"),
			button: $(this).data("button"),
			forms: $(this).data("forms"),
			send: $(this).data("send")
		})).init();
		return false;
	});

});