function setWindowHeight() {
	$(".window .container").css("max-height", parseInt($(document).height()) - 150);
}

$(document).ready(function () {

	$wrapper = $("#wrapper");
	$ajaxWrapper = $("#ajax-wrapper");
	$templates = $("#templates");
	$loader = $templates.find(".loader");
	$forms = $("#forms");
	$errors = $("#errors");

	setWindowHeight();
	$(window).resize(function () {
		setWindowHeight();
	});

	$("#login-button").on("click", function () {
		(new Window("user/form")).init();
		return false;
	});

	$("#logout-button").on("click", function () {
		$.ajax({
			url: "/ajax/" + LANG + "/user/logout/",
			success: function () {
				window.location.replace("");
			}
		});

		return false;
	});

});